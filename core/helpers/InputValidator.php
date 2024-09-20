<?php

namespace Helpers;

class InputValidator
{
  static  function cleanParameter($param, $type) {
        switch ($type) {
            case "EMAIL":
                $param = filter_var($param, FILTER_SANITIZE_EMAIL);
                if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                break;
            case "INTEGER":
                $param = filter_var($param, FILTER_SANITIZE_NUMBER_INT);
                if (!filter_var($param, FILTER_VALIDATE_INT)) {
                    return false;
                }
                break;
            case "FLOAT":
                $param = filter_var($param, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                if (!filter_var($param, FILTER_VALIDATE_FLOAT)) {
                    return false;
                }
                break;
            case "URL":
                $param = filter_var($param, FILTER_SANITIZE_URL);
                if (!filter_var($param, FILTER_VALIDATE_URL)) {
                    return false;
                }
                break;
            case "BOOLEAN":
                $param = filter_var($param, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($param === null) {
                    return false;
                }
                break;
            case "IP":
                if (!filter_var($param, FILTER_VALIDATE_IP)) {
                    return false;
                }
                break;
            case "MAC":
                if (!filter_var($param, FILTER_VALIDATE_MAC)) {
                    return false;
                }
                break;
            case "ALPHANUMERIC":
                if (!ctype_alnum($param)) {
                    return false;
                }
                break;
            case "DATE":
                $d = DateTime::createFromFormat('Y-m-d', $param);
                if (!$d || $d->format('Y-m-d') !== $param) {
                    return false;
                }
                break;
            case "REGEX":
                if (!preg_match("/^[A-Za-z0-9_]+$/", $param)) {
                    return false;
                }
                break;
            default:
                $param = htmlspecialchars($param, ENT_QUOTES, 'UTF-8');
                break;
        }
        
        return $param;
    }
    
}
