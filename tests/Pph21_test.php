<?php
namespace PajakUnitTest;

require_once "vendor/autoload.php";
require_once "Pph21.php";

use PHPUnit\Framework\TestCase;
use Pajak\Pph21 as Pph21;

class Pph21Test extends TestCase{
	
	public function testGetValue()
    {
		$month_salary = 7800000;
		$married_status = 1; // 1 : Married, 0 : Single
		$children = 1;

		$pajak = new Pph21($month_salary, $married_status, $children);
		
		$this->assertEquals($month_salary, $pajak->getMonthSalary());
        $this->assertEquals($married_status, $pajak->getMarriedStatus());
        $this->assertEquals($children, $pajak->getChildren());
    }
	
	public function testCalculateTax()
    {
		$month_salary = 7800000;
		$married_status = 1; // 1 : Married, 0 : Single
		$children = 1;

		$pajak = new Pph21($month_salary, $married_status, $children);
		$ptkp_tahunan = $pajak->calculateTaxableIncome();
		$pajak_tahunan = $pajak->calculateTaxIncome();
		
		$this->assertIsNumeric($ptkp_tahunan);
		$this->assertIsNumeric($pajak_tahunan);
    }
}	
?>
