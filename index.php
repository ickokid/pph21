<?php
require_once "Pph21.php";
use Pajak\Pph21 as Pph21;

$month_salary = 7800000;
$married_status = 1; // 1 : Married, 0 : Single
$children = 1;

$pajak = new Pph21($month_salary, $married_status, $children);
$ptkp_tahunan = $pajak->calculateTaxableIncome();
$pajak_tahunan = $pajak->calculateTaxIncome();

echo "Monthly Salary (Penghasilan Bersih Bulanan) : ".number_format($month_salary, 0, ',', '.')."<br>";
echo "Annual Taxable Income (Penghasilan Tidak Kena Pajak Tahunan) : ".number_format($ptkp_tahunan, 0, ',', '.')."<br>";
echo "Annual Tax Income (Pajak Penghasilan Tahunan) : ".number_format($pajak_tahunan, 0, ',', '.')."<br>";
?>
