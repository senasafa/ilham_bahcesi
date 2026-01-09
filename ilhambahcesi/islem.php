<?php
include('db.php');
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}

$uid   = $_SESSION['user_id'];
$durum = $_GET['durum'] ?? '';


if($durum === 'sec'){
    $tip = $conn->real_escape_string($_GET['tip'] ?? ''); 

    if($tip != ''){
        
        $conn->query("
            UPDATE user_creatures 
            SET status='inactive' 
            WHERE user_id='$uid' AND status='active'
        ");

        $conn->query("
            INSERT INTO user_creatures (user_id, type, level, yardım_tl, status, farm_added)
            VALUES ('$uid', '$tip', 1, 0, 'active', 0)
        ");
    }

    header("Location: dashboard.php");
    exit;
}

if($durum === 'buyu'){
    $active = $conn->query("
        SELECT * FROM user_creatures 
        WHERE user_id='$uid' AND status='active'
        LIMIT 1
    ")->fetch_assoc();

    if($active){
        $newLevel  = $active['level'];
        $newYardim = $active['yardım_tl'] + 5; // +5 TL ekleme

        // Eğer seviye 3'ten küçükse seviye atlat
        if($newLevel < 3){
            $newLevel++;
        }

        // Seviye ve Yardım güncellemesi yap
        $conn->query("
            UPDATE user_creatures 
            SET level='$newLevel', yardım_tl='$newYardim'
            WHERE id='{$active['id']}'
        ");


        if($newLevel >= 3){
            $conn->query("
                UPDATE user_creatures 
                SET farm_added=1, status='farmed'
                WHERE id='{$active['id']}'
            ");
        }
    }

    header("Location: dashboard.php?mesaj=basari");
    exit;
}

if($durum === 'sifirla'){
    $conn->query("
        UPDATE user_creatures 
        SET status='inactive'
        WHERE user_id='$uid' AND status='active'
    ");

    header("Location: dashboard.php");
    exit;
}
?>