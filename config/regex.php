<?php 
  namespace Regex;
 # exemple : 0895512717
  const PHONE = '/^0[0-9]{9}$/';
  # exemple : Yan 
  const USERNAME = '/^[A-Za-z]{3,}$/';
  # exemple : 45, 33
  const PRICE = '/^\d+$/';

?>