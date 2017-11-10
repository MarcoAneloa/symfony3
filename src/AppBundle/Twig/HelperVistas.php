<?php
namespace AppBundle\Twig;

class HelperVistas extends \Twig_Extension{

    public function getFunctions() {
        return array('generateTable' =>  new \Twig_Function_Method($this,'generateTable'));
    }

    public function generateTable($nums_columns,$nums_rows,$resultSet){
        $table="<table class='table' border='1'>";
        for($i=0;$i<count($resultSet);$i++){
            $table.="<tr>";
            for($j=0;$j<count($resultSet[$i]);$j++){
                $resultSetValues=array_values($resultSet[$i]);
                $table.="<td>$resultSetValues[$j]</td>";
            }
            $table.="</tr>";
        }
        $table.="</table>";
        return $table;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "AppBundle";
    }
}