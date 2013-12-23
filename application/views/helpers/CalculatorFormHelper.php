<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 14/12/13
 * Time: 17:07
 */

namespace application\views\helpers;


use library\helpers\ViewHelper;

class CalculatorFormHelper extends ViewHelper
{
    /*
     * $params['action']
     * $params['id']
     * $params['buttonValue']
     */
    function __construct($params=array())
    {
        $this->_html = '
            <form
                class="form-horizontal"
                role="form"
                action="' . $params['action'] . '"
                id="' . $params['id'] . '"
                method="post"
            >
              <div class="form-group">
                <label for="inputOperator1" class="col-sm-2 control-label">Operator1</label>
                <div class="col-sm-10">
                  <input type="number" name="op1" class="form-control" id="inputOperator1" placeholder="Operator1">
                </div>
              </div>
              <div class="form-group">
                <label for="inputOperator2" class="col-sm-2 control-label">Operator2</label>
                <div class="col-sm-10">
                  <input type="number" name="op2" class="form-control" id="inputOperator2" placeholder="Operator2">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">' . $params['buttonValue'] . '</button>
                </div>
              </div>
            </form>
        ';
    }
}