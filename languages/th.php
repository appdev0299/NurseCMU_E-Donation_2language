<?php
require_once 'config_th/connection_l.php';
$query_menu_th = "SELECT home, donation, donation_steps, list_of_donors, benefits, contact, obj, details_of,
rec_email1, rec_email2, amount, name_title, donation_fullname, rec_idname, rec_tel,
address, provinces, amphures, districts, submit,status_receipt,address_nuser,header,project,back,total_amount,currency,keyword_name,keyword_tex
FROM menu_th;
";
$query_details = "SELECT `edo_name`,`edo_description` FROM project_th";
try {
    $result_menu_th = $conn->query($query_menu_th);
    $menu_th = $result_menu_th->fetch(PDO::FETCH_ASSOC);
    $result_details = $conn->query($query_details);
    $details = $result_details->fetch(PDO::FETCH_ASSOC);
    $lang = array(
        "home" => $menu_th["home"],
        "donation" => $menu_th["donation"],
        "donation_steps" => $menu_th["donation_steps"],
        "list_of_donors" => $menu_th["list_of_donors"],
        "benefits" => $menu_th["benefits"],
        "contact" => $menu_th["contact"],
        "obj" => $menu_th["obj"],
        "details_of" => $menu_th["details_of"],
        "rec_email1" => $menu_th["rec_email1"],
        "rec_email2" => $menu_th["rec_email2"],
        "amount" => $menu_th["amount"],
        "name_title" => $menu_th["name_title"],
        "donation_fullname" => $menu_th["donation_fullname"],
        "rec_idname" => $menu_th["rec_idname"],
        "rec_tel" => $menu_th["rec_tel"],
        "address" => $menu_th["address"],
        "provinces" => $menu_th["provinces"],
        "amphures" => $menu_th["amphures"],
        "districts" => $menu_th["districts"],
        "submit" => $menu_th["submit"],
        "status_receipt" => $menu_th["status_receipt"],
        "address_nuser" => $menu_th["address_nuser"],
        "header" => $menu_th["header"],
        "back" => $menu_th["back"],
        "project" => $menu_th["project"],
        "total_amount" => $menu_th["total_amount"],
        "currency" => $menu_th["currency"],
        "keyword_name" => $menu_th["keyword_name"],
        "keyword_tex" => $menu_th["keyword_tex"],

        "edo_name" => $details["edo_name"],
        "lang_en" => "อังกฤษ",
        "lang_th" => "ไทย"
    );
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
