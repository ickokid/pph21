<?php 
namespace Pajak;

define('PTKP_TK0', 54000000);
define('PTKP_K0', 58500000);
define('PTKP_K1', 63000000);
define('PTKP_K2', 67500000);
define('PTKP_K3', 72000000);

define('TAX_SCHEME_LEVEL_1', 0.05);
define('TAX_SCHEME_LEVEL_2', 0.15);
define('TAX_SCHEME_LEVEL_3', 0.25);
define('TAX_SCHEME_LEVEL_4', 0.35);

class Pph21{
	private $month_salary = 0;
	private $married_status = 0;
	private $children = 0;
	private $taxable_income = 0;
	
	public function __construct($month_salary, $married_status, $children)
    {
        $this->month_salary = $month_salary;
		$this->married_status = $married_status;
		$this->children = $children;
    }
	
	public function getMonthSalary()
    {
        return $this->month_salary;
    }

    public function getMarriedStatus()
    {
        return $this->married_status;
    }

    public function getChildren()
    {
        return $this->children;
    }
	
	function calculateTaxableIncome(){
		//Tax Reliefs
		/*
		- TK0 - Single : 54.000.000 IDR
		- K0 - Married with no dependant : 58.500.000 IDR
		- K1 - Married with 1 dependant  : 63.000.000 IDR
		- K2 - Married with 2 dependants : 67.500.000 IDR
		- K3 - Married with 3 dependants : 72.000.000 IDR 
		*/
		
		if($this->married_status){
			if($this->children >= 3){
				$tax_reliefs = PTKP_K3;
			} else if($this->children == 2){
				$tax_reliefs = PTKP_K2;
			} else if($this->children == 1){
				$tax_reliefs = PTKP_K1;
			} else {
				$tax_reliefs = PTKP_K0;
			}	
		} else {
			$tax_reliefs = PTKP_TK0;
		}

		$this->taxable_income = ($this->month_salary * 12) - $tax_reliefs;
		
		return $this->taxable_income;
	}

	function calculateTaxIncome(){
		//Scheme income taxation, personal income tax
		/*
		- Annual income from 0 to 50.000.000 IDR - tax rate is 5%
		- Annual income from 50.000.000 to 250.000.000 IDR - tax rate is 15%
		- Annual income from 250.000.000 to 500.000.000 IDR - tax rate is 25%
		- Annual income above 500.000.000 IDR - tax rate is 30% 
		*/
		
		if($this->taxable_income == 0){
			die('Please calculate Taxable Income');
		}	
		
		$tax_yearly = 0;
		$tax_yearly_1 = 0;
		$tax_yearly_2 = 0;
		$tax_yearly_3 = 0;
		$tax_yearly_4 = 0;
		
		if($this->taxable_income > 500000000){
			$this->taxable_income = $this->taxable_income - 50000000;
			$tax_yearly_4 = TAX_SCHEME_LEVEL_4 * $this->taxable_income;
		}
		
		if($this->taxable_income >= 250000000 && $this->taxable_income <= 500000000){
			$this->taxable_income = $this->taxable_income - 50000000;
			$tax_yearly_3 = TAX_SCHEME_LEVEL_3 * $this->taxable_income;
		}
		
		if($this->taxable_income >= 50000000 && $this->taxable_income <= 250000000){
			$this->taxable_income = $this->taxable_income - 50000000;
			$tax_yearly_2 = TAX_SCHEME_LEVEL_2 * $this->taxable_income;
		} 
		
		if($this->taxable_income > 0 && $this->taxable_income <= 50000000){
			$tax_yearly_1 = TAX_SCHEME_LEVEL_1 * $this->taxable_income;
		} 
		
		$tax_yearly = $tax_yearly_1 + $tax_yearly_2 + $tax_yearly_3 + $tax_yearly_4;
		
		return $tax_yearly;
	}
}	
?>
