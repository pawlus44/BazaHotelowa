<?php
class My_Validators_CorrectValue extends Zend_Validate_Abstract
{
        const NOT_CONTENT_SMALL_LETTER = 'notcontentsmallletter';
        const NOT_CONTENT_HUGE_LETTER = 'notcontenthugeletter';
        const NOT_CONTENT_DIGITS = 'noncontentdigits';
        const EMPTYSTRING = 'emptystring';
        const NULLVALUE = 'nullvalue';

  protected $_messageTemplates = array(
    self::NOT_CONTENT_SMALL_LETTER   => "'%value%' not content small letter",
    self::NOT_CONTENT_HUGE_LETTER   => "'%value%' not content huge letter",
    self::NOT_CONTENT_DIGITS   => "'%value%' not content digits",
    self::EMPTYSTRING  => 'given value is empty',
    self::NULLVALUE     => 'given value is null'
  );



    public function isValid($value) {

        // sprawdzamy czy zmienna nie jest nulem, a jeżeli tak to ustawiamy błąd
        if ($value === null) {
          $this->_error(self::NULLVALUE);
          return false;
        }

        // to samo dla pustego stringa
        if ($value === '') {
          $this->_error(self::EMPTYSTRING);
          return false;
        }

        //$value = (int) $value;

        // ustawiamy wartość dla ewentualnego komunikatu %value%
        $this->_setValue($value);
        $isnotcorrect = 0;

        if( preg_match('/[0-9]{1,}/',$value))
        {
            //$isnotcorrect = 0;
        }else
        {
            $isnotcorrect = 1;
            $this->_error(self::NOT_CONTENT_DIGITS);
        }
        
        if(preg_match('/[a-z]{1,}/',$value))
        {
           // $isnotcorrect = 0;
        }else
        {
            $isnotcorrect = 1;
            $this->_error(self::NOT_CONTENT_SMALL_LETTER);
        }
/*
        if(preg_match('/[A-Z]{1,}/',$value))
        {
            //$isnotcorrect = 0;
        }else
        {
            $isnotcorrect = 1;
            $this->_error(self::NOT_CONTENT_HUGE_LETTER);
        }
*/

        if( $isnotcorrect == 1)
        {
        return false;
        }else
        {
        return true;
        }
        // jeżeli nic nie znaleziono tzn. że sprawdzany klucz nie istenieje w tabeli bazy

      }
}
?>
