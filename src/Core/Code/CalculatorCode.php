<?php

namespace Tao\Captcha\Core\Code;


use Tao\Captcha\Core\Helper;

class CalculatorCode extends AbstractCode
{
    private $_operation;
    private $_nums;

    public function __construct()
    {
        parent::__construct();
        $this->getOperation();
    }

    protected function asciiCode(): string
    {
        $arabicNum1 = Helper::shuffleString($this->num_config['chars'], 1, 1);
        $arabicNum2 = Helper::shuffleString($this->num_config['chars'], 1, 1);

        // Put the larger number at the beginning to avoid negative result
        list($arabicNum1, $arabicNum2) = intval($arabicNum1) < intval($arabicNum2) ? array($arabicNum2, $arabicNum1) : array($arabicNum1, $arabicNum2);
        $this->_nums = [$arabicNum1, $arabicNum2];
        return $arabicNum1 . $this->_operation['operation'] . $arabicNum2 . '=';
    }

    protected function nonAsciiCode(): string
    {
        $num1 = Helper::shuffleString($this->num_config['chars'], 1, 1);
        $arabicNum1 = Helper::chineseNumToArabicNum($num1);
        $num2 = Helper::shuffleString($this->num_config['chars'], 1, 1);
        $arabicNum2 = Helper::chineseNumToArabicNum($num2);

        // Put the larger number at the beginning to avoid negative result
        list($num1, $num2) = intval($arabicNum1) < intval($arabicNum2) ? array($num2, $num1) : array($num1, $num2);
        $this->_nums = [$arabicNum1, $arabicNum2];
        return $num1 . $this->_operation['operation'] . $num2 . '等于';
    }

    protected function validationCode(): int
    {
        return $this->calculate($this->_nums[0], $this->_nums[1], $this->_operation['position']);
    }

    private function getOperation()
    {
        $operations = $this->num_config['operations'];
        $operation = Helper::shuffleString($operations, 1, 1);
        $operation_position = mb_strpos($operations, $operation);
        $this->_operation = [
            'operation' => $operation,
            'position' => $operation_position
        ];
    }

    private function calculate($num1, $num2, $op_pos): float
    {
        $result = 0;
        switch ($op_pos) {
            case 0:
                $result = $num1 + $num2;
                break;
            case 1 :
                $result = abs($num1 - $num2);
                break;
            case 2:
                $result = $num1 * $num2;
                break;
        }

        return $result;
    }

}
