<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class AtaPaginator extends Paginator {

    private $searchItemArrays = array();
    private $orderItemArrays = array();

    /**
     * 
     * @return Array
     */
    public function getSearchItemArrays() {
        return $this->searchItemArrays;
    }

    /**
     * 
     * @return Array
     */
    public function getOrderItemArrays() {
        return $this->orderItemArrays;
    }

    /**
     * 
     * @param Array $searchItemArrays
     */
    public function setSearchItemArrays($searchItemArrays) {
        $this->searchItemArrays = $searchItemArrays;
    }

    /**
     * 
     * @param Array $orderItemArrays
     */
    public function setOrderItemArrays($orderItemArrays) {
        $this->orderItemArrays = $orderItemArrays;
    }

    /**
     * Create Simple Header for items
     * @param type $enableSearch
     * @param type $enableOrder
     */
    public function getHeader($enableSearch = true, $enableOrder = true) {

        $result = "
            
            <form method='post' class='paginator-header form-inline'>
                ";
        // we have to check if we have any search array, add that
        if (is_array($this->searchItemArrays) && count($this->searchItemArrays) > 0) {
            // there are some option to add
            $result.= "Search In &nbsp&nbsp";
            $result.= "<select name='target'>";
            foreach ($this->getSearchItemArrays() as $key => $value) {
                $result.="<option value='$key'>$value</option>";
            }
            $result.="</select>";
            $result .= "
                <div class='input-group'>
                    <input class='form-control' type='text' name='searchquery' placeholder='Search Text Goes Here...' />
                    <span class='input-group-btn'>
                      <input type='submit' value='Search' class='btn btn-primary'>Search</button>
                    </span>
                </div>
                ";
        }
        $result.="
            </form>
            ";
        return $result;
    }

    /**
     * Return Paginator
     * @return type
     */
    public function getPaginate() {
        $paginate = parent::getPaginate();
        $paginate->header = $this->getHeader();
        return $paginate;
    }

}
