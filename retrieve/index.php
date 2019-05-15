<?
require  __DIR__.'/another.php';
if(!isset($_GET['id']))
{
	die("Enter ID, please");
}

$id = $_GET['id'];
$get = new get_data();
$result = $get->search($id);

if(!isset($result))
{
	die("Wrong ID");
}
else
{
	echo $result;
}

?>