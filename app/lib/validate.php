<?php

namespace PHPMVC\Lib;

trait Validate {

    private $_regexPatterns = [
        'num' => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int' => '/^[0-9]+$/',
        'float' => '/^[0-9]+\.[0-9]+$/',
        'alpha' => '/^[a-zA-Z\p{Arabic} ]+$/u',
        'alphanum' => '/^[a-zA-Z\p{Arabic}0-9 ]+$/u',
        'vdate' => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:(?:1|2)[0-9])|(?:3[0-1]))$/',
        'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'url' => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
    ];

    public function num($value) {
        return (bool) preg_match($this->_regexPatterns['num'], $value);
    }

    public function int($value) {
        return (bool) preg_match($this->_regexPatterns['int'], $value);
    }

    public function float($value) {
        return (bool) preg_match($this->_regexPatterns['float'], $value);
    }

    public function alpha($value) {
        return (bool) preg_match($this->_regexPatterns['alpha'], $value);
    }

    public function alphaNum($value) {
        return (bool) preg_match($this->_regexPatterns['alphanum'], $value);
    }

    public function req($value) {
        return $value != '' && !empty($value);
    }

    public function lt($value, $matchAgainst) {
        if (is_string($value)) {
            return mb_strlen($value) < $matchAgainst;
        } elseif (is_numeric($value)) {
            return $value < $matchAgainst;
        }
    }

    public function eq($value, $matchAgainst) {
        return $value == $matchAgainst;
    }
    
    public function eqField($value, $otherFieldValue) {
        return $value == $otherFieldValue;
    }

    public function min($value, $min) {
        if (is_numeric($value)) {
            return $value >= $min;
        } else if (is_string($value)) {
            return mb_strlen($value) >= $min;
        }
    }

    public function max($value, $max) {
        if (is_string($value)) {
            return mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value <= $max;
        }
    }

    public function between($value, $min, $max) {
        if (is_string($value)) {
            return mb_strlen($value) >= $min && mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value >= $min && $value <= $max;
        }
    }

    public function floatLike($value, $beforDP, $afterDP) {
        if (!$this->float($value)) {
            return false;
        }
        $pattern = '/^[0-9]{' . $beforDP . '}\.[0-9]{' . $afterDP . '}$/';
        return (bool) preg_match($pattern, $value);
    }

    public function vdate($value) {
        return (bool) preg_match($this->_regexPatterns['vdate'], $value);
    }

    public function email($value) {
        return (bool) preg_match($this->_regexPatterns['email'], $value);
    }

    public function url($value) {
        return (bool) preg_match($this->_regexPatterns['url'], $value);
    }

    public function isValid($roles, $inputType) {
        $errors = [];
        if (!empty($roles)) {
            foreach ($roles as $fieldName => $validationRoles) {
                $value = $inputType[$fieldName];
                $validationRoles = explode('|', $validationRoles);
                foreach ($validationRoles as $validationRole) {
                    if(array_key_exists($fieldName, $errors))
                            continue;
                    if (preg_match('/(min)\((\d+)\)/', $validationRole, $m)) {
                        if ($this->min($value, $m[2]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(max)\((\d+)\)/', $validationRole, $m)) {
                        if ($this->max($value, $m[2]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(lt)\((\d+)\)/', $validationRole, $m)) {
                        if ($this->lt($value, $m[2]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(gt)\((\d+)\)/', $validationRole, $m)) {
                        if ($this->gt($value, $m[2]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(eq)\((\w+)\)/', $validationRole, $m)) {
                        if ($this->eq($value, $m[2]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(eqField)\((\w+)\)/', $validationRole, $m)) {
                        $otherFieldValue = $inputType[$m[2]];
                        if ($this->eqField($value, $otherFieldValue) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $this->language->get('text_label_' . $m[2])]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(between)\((\d+),(\d+)\)/', $validationRole, $m)) {
                        if ($this->between($value, $m[2], $m[3]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2], $m[3]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } elseif (preg_match('/(floatLike)\((\d+),(\d+)\)/', $validationRole, $m)) {
                        if ($this->floatLike($value, $m[2], $m[3]) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $m[1], [$this->language->get('text_label_' . $fieldName), $m[2], $m[3]]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    } else {
                        if ($this->$validationRole($value) === false) {
                            $this->messenger->add(
                                    $this->language->feedKey('text_error_' . $validationRole, [$this->language->get('text_label_' . $fieldName)]),
                                    Messenger::APP_MESSAGE_ERROR
                            );
                            $errors[$fieldName] = true;
                        }
                    }
                }
            }
        }
        return empty($errors) ? true : false;
    }

}
