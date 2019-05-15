<?
require_once __DIR__.'/../base.php';
class onstart
{
	private $input_list;

	public function __call($name,$args) 
	{
    	throw new BadMethodCallException("' $name ' type doesn't exist. Please, try another type."); // обработка ошибки вызванной введением неизвестного типа генерации
    }

	private function storage($token,$data)
	{
		global $mysqli;
		$instoken = $mysqli->prepare("INSERT INTO `genered_list`(`result`,`data`) VALUES (?,?)") or die("DataBase connection error");
		$instoken->bind_param("ss",$token,$data);
		$instoken->execute();
		mysqli_stmt_close($instoken);
		mysqli_close($mysqli);
	}

	public function method($data,$type,$len,$input=false)
	{
		global $input_list;
		$this->$input_list = $input;
		$token = $this->$type($len);
		$this->storage($token,$data);
		return $token;
	}

	private function both($len)
	{
		$lib = $this->library(true,true,true);
		$gen = new tokengen();
		return $gen->genkey($lib,$len);
	}

	private function guid($len)
	{
        $lib = $this->library(false,true,true);
        $gen = new tokengen();
		$guid = $gen->genkey($lib,$len);
		$guid = '{'.substr($guid, 0,8).'-'.substr($guid, 8,4).'-'.substr($guid, 12,4).'-'.substr($guid, 16, 4).'-'.substr($guid, 20,12).'}';
		return $guid;
	}

	private function str($len)
	{
		$lib = $this->library(true,true,false);
		$gen = new tokengen();
		return $gen->genkey($lib,$len);
	}

	private function numberic($len)
	{
		$lib = $this->library(false,false,true);
		$gen = new tokengen();
		return $gen->genkey($lib,$len);
	}

	private function input($len)
	{
		global $input_list;
		$lib = str_split($this->$input_list);
		$gen = new tokengen();
		return $gen->genkey($lib,$len);
	}

	private function library($l,$u,$n)
	{
		$low = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		$up = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
		$num = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
		$ret = array();
		if($l): $ret = array_merge($ret,$low); endif;
		if($u): $ret = array_merge($ret,$up); endif;
		if($n): $ret = array_merge($ret,$num); endif;
		shuffle($ret);
		return $ret;
	}
}

class tokengen
{
	/* Генерация случайного ключа для взаимодействия с библиотекой символов */
	public function genkey($lib,$len)
	{
		$atmoment = strtotime("now"); // время текущего момента в секундах
		while(strlen($atmoment)*2 < $len) // пока длина ключа меньше более чем в 2 раза чем заданная длина
		{
			$atmoment .= strrev($atmoment); // вписываем его зеркальные копии
		}
		$i = $atmoment[strlen($atmoment)%4]; // создаём случайный счётчик
		while(strlen($atmoment) < $len) // и пока длина ключа меньше длины требуемой
		{
			$atmoment .= $atmoment[$i]; // заносим случайное число из ключа в ключ
			$i = $atmoment[strlen($atmoment)%3]-1; // меняем счётчик. Случайно.
		}
		return $this->assoc($atmoment,$lib);
	}

	private function assoc($mask,$lib)
	{
		$token = '';
		$mask = str_split($mask);
		$max = count($lib);
		foreach ($mask as $value) 
		{
			$token .= $lib[((int)$value*rand())%$max];
		}
		return $token;
	}
}


?>