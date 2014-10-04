<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class AtaPaginator extends Paginator {

    private $searchItemArrays = array();
    private $orderItemArrays = array();
    private $listPath;
    private $editUrl;
    private $deleteUrl;
    private $tableHeaders = array();
    private $fields = array();

    public function getViewUrl() {
        return $this->editUrl;
    }

    public function getDeleteUrl() {
        return $this->deleteUrl;
    }

    /**
     * 
     * @param type $viewUrl
     * @return AtaPaginator
     */
    public function setEditUrl($viewUrl) {
        $this->editUrl = $viewUrl;
        return $this;
    }

    /**
     * 
     * @param type $deleteUrl
     * @return AtaPaginator
     */
    public function setDeleteUrl($deleteUrl) {
        $this->deleteUrl = $deleteUrl;
        return $this;
    }

    public function getTableHeaders() {
        return $this->tableHeaders;
    }

    public function getFields() {
        return $this->fields;
    }

    /**
     * 
     * @param type $tableHeaders
     * @return AtaPaginator
     */
    public function setTableHeaders($tableHeaders) {
        $this->tableHeaders = $tableHeaders;
        return $this;
    }

    /**
     * 
     * @param type $fields
     * @return AtaPaginator
     */
    public function setFields($fields) {
        $this->fields = $fields;
        return $this;
    }

    public function getListPath() {
        return $this->listPath;
    }

    /**
     * 
     * @param type $listPath
     * @return AtaPaginator
     */
    public function setListPath($listPath) {
        $this->listPath = $listPath;
        return $this;
    }

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
     * Return Paginator
     * @return type
     */
    public function getPaginate() {
        $paginate = parent::getPaginate();
        $paginate->header = $this->getHeader();
        $paginate->table = $this->getTable($paginate);
        $paginate->footer = $this->getFooter($paginate, $this->getListPath());
        return $paginate;
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
     * return the footer of the page
     * @param type $paginate
     * @param String $listPath page path like user/list
     * @return type
     */
    public function getFooter($paginate, $listPath) {

        return "
            <!-- Pagination Items !-->
            <div class='center'>
                <div class='pagination pagination-centered'>
                    <li> <a class='pag' href='$listPath/'>First</a></li>
                    <li> <a href='$listPath/$paginate->before'>Previous</a></li>
                    <li> <a href='$listPath/$paginate->next'>Next</a></li>
                    <li> <a href='$listPath/$paginate->last'>Last</a></li>
                </div>
                <div>
                    You are in page $paginate->current of $paginate->total_pages
                </div>
            </div>";
    }

    public function getTable($paginate) {
        $result = "";

        // add table head
        $result .= "
            <div class='table-responsive'>
            <table class='table table-bordered table-striped table-condensed mb-none '>
                <tr>";

        // add each fileds
        foreach ($this->getTableHeaders() as $value) {
            $result .= "<th>$value</th>";
        }

        // add action box
        $result .= "<th>Action</th>";

        // close the table fields
        $result .= "<tr>";


        // add each item
        $i = 0;
        foreach ($paginate->items as $item) {
            $result .= "<tr>";
            foreach ($this->getFields() as $key => $value) {
                $text = $item->$value;
                $result .= "<td>$text</td>";
            }

            // add action bar
            $result .= "
                <td>
                     <a href='$this->editUrl/$item->id' class='on-default edit-row'><i class='fa fa-pencil'></i></a>
                     <a href='$this->deleteUrl/$item->id' class='on-default remove-row'><i class='fa fa-trash-o'></i></a>
                </td>";

            $result .= "</tr>";
            $i++;
        }

        // close the table
        $result .= "</table>
        </div>";




        // return the result
        return $result;
    }

}
