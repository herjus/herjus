<?php 

class Calc
{
	public $num1;
	public $num2;
	public $operator;

	public function __construct($num1, $num2, $operator)
	{
		$this -> num1=$num1;
		$this -> num2=$num2;
		$this -> operator=$operator;
	}
	public function __destruct()
	{echo __CLASS__.' destroyed';}

	public function getResult()
	{
		if(isset($this->num1) && isset($this->num2) && isset($this->operator))
		{
			switch ($this->operator) 
			{
			
				case 'add':
					$result = $this -> num1 + $this -> num2;
					break;
				case 'subtract':
					$result = $this -> num1 - $this -> num2;
					break;
				case 'multiply':
					$result = $this -> num1 * $this -> num2;
					break;
				case 'divide':
					if($this->num2 == 0) $result = "infinity";
					else $result = $this -> num1 / $this -> num2;
					break;
				default:
					$result = "Error";
					break;
			}
		}
		else $result = "Inputs missing.";
	return $result;
	}
}