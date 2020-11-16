<?php
namespace App\Service;

class JankenService
{
    public function jankenAction($myResult, $cpuResult)
    {
        if (($myResult - $cpuResult) == -2 || ($myResult - $cpuResult) == 1) {
            $plusPoint = 5;
            $result = '勝ち';
        } elseif (($myResult) == ($cpuResult)) {
            $plusPoint = -10;
            $result = '引き分け';
        } else {
            $plusPoint = -10;
            $result = '負け';
        }
        return [$plusPoint, $result];
    }
}
