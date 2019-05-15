<?
require  __DIR__.'/another.php';

if(!isset($_POST['data']))
{
	die("Enter some data");
}
else
{
	$data = $_POST['data'];
}

$start = new onstart();
$type = 'both';
$len = 32;
$list = false;
$result = '';

if(isset($_POST['type']))
{
	$type = $_POST['type'];
}
if(isset($_POST['len']))
{
	$len = $_POST['len'];
}
if(isset($_POST['list']))
{
	$list = $_POST['list'];
}

if($len < 16)
{
	die("Too short length. Please enter another length value greater than 16");
}

if($type === 'guid')
{
	$len = 32;
}

try
{
	$result = $start->method($data,$type,$len,$list);
}
catch(Exception $e) 
{
    die($e->getMessage());
} 
echo $result;

?>