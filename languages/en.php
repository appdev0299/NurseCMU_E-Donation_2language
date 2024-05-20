<?php
require_once 'config_th/connection_l.php';
$query_menu_en = "SELECT home, donation, donation_steps, list_of_donors, benefits, contact, obj, details_of,
rec_email1, rec_email2, amount, name_title, donation_fullname, rec_idname, rec_tel,
address, provinces, amphures, districts, submit,status_receipt,address_nuser,header,project,back,total_amount,currency,keyword_name, keyword_tex
FROM menu_en;
";
$query_details = "SELECT `edo_name`,`edo_description` FROM project_en";
try {
	$result_menu_en = $conn->query($query_menu_en);
	$menu_en = $result_menu_en->fetch(PDO::FETCH_ASSOC);
	$result_details = $conn->query($query_details);
	$details = $result_details->fetch(PDO::FETCH_ASSOC);
	$lang = array(
		"home" => $menu_en["home"],
		"donation" => $menu_en["donation"],
		"donation_steps" => $menu_en["donation_steps"],
		"list_of_donors" => $menu_en["list_of_donors"],
		"benefits" => $menu_en["benefits"],
		"contact" => $menu_en["contact"],
		"obj" => $menu_en["obj"],
		"details_of" => $menu_en["details_of"],
		"rec_email1" => $menu_en["rec_email1"],
		"rec_email2" => $menu_en["rec_email2"],
		"amount" => $menu_en["amount"],
		"name_title" => $menu_en["name_title"],
		"donation_fullname" => $menu_en["donation_fullname"],
		"rec_idname" => $menu_en["rec_idname"],
		"rec_tel" => $menu_en["rec_tel"],
		"address" => $menu_en["address"],
		"provinces" => $menu_en["provinces"],
		"amphures" => $menu_en["amphures"],
		"districts" => $menu_en["districts"],
		"submit" => $menu_en["submit"],
		"status_receipt" => $menu_en["status_receipt"],
		"address_nuser" => $menu_en["address_nuser"],
		"header" => $menu_en["header"],
		"back" => $menu_en["back"],
		"project" => $menu_en["project"],
		"total_amount" => $menu_en["total_amount"],
		"currency" => $menu_en["currency"],
		"keyword_name" => $menu_en["keyword_name"],
		"keyword_tex" => $menu_en["keyword_tex"],

		"edo_name" => $details["edo_name"],
		"lang_en" => "English",
		"lang_th" => "Thai"
	);
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$conn = null;
