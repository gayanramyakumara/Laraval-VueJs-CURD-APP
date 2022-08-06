<?php
namespace App;

class Utils {
   const COMMON_ERROR_MESSAGE = 'Something went wrong.Please try again later.';
   const ERROR_TYPE_COM = "common";

   const ERROR_CODE_UNPROCESSABLE = 422;
   const ERROR_CODE_SUCCESS     = 200;

   const CURRENCY_LIST = ["AED", "AUD", "BGN", "CAD", "CHF", "CZK", "DKK", "EUR", "GBP", "ZAR"];
   
   const PAGINATION_LIMIT = 3;

   const REVOLUT_API_FAILURE = "API faillure";

}