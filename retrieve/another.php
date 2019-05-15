<?
require_once __DIR__.'/../base.php';

class get_data
{
	public function search($id)
	{
		global $mysqli;
		$gettoken = $mysqli->prepare("SELECT `data` FROM `genered_list` WHERE `result`=?") or die("DataBase connection error");
		$gettoken->bind_param("s",$id);
		$gettoken->execute();
		$gettoken->bind_result($result);
		$gettoken->fetch();
		mysqli_stmt_close($gettoken);
		mysqli_close($mysqli);
		return $result;
	}
}

?>