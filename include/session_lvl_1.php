<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");

    if(!isset($_SESSION['JWT_Dengue_Fever'])){
        header("location: ../503.php");
    }
    if(!empty($_SESSION['JWT_Dengue_Fever'])){
        $authorization = $_SESSION['JWT_Dengue_Fever'];
        $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

        $s_check = "SELECT count(*) as count_check FROM dhf_user WHERE dhf_user = '".$token->dhf_user."' AND dhf_level = '1';";  
        $r_check = $db_saraburi->prepare($s_check);
        $r_check->execute();
        $results = $r_check->fetchAll();
    }

    if (empty($_SESSION['JWT_Dengue_Fever']) || $results[0]['count_check'] != 1) {
        session_destroy();
        header("location: ../503.php");
    }

    $now_page = basename($_SERVER['PHP_SELF']);
    if($now_page == "index_hi_ci.php" || $now_page == "manage_hici.php" || $now_page == "view_map_hici.php" || $now_page == "trace_hici.php"){
        if($token->group_id != "1"){
            header("location: index.php");
        }
    }
?>