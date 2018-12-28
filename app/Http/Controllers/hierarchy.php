<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class hierarchy extends Controller
{
    //
    public function test(Request $request){

      $flattened=[];
      foreach ($request->all() as $employee => $supervisor) {
        	if(sizeof($flattened)==0)
        	{
        		$employeeArray=[];
        		$employeeArray[$employee]=[];
        		$flattened[$supervisor]=$employeeArray;
        	}
        	else{
        		$this->tree($flattened,$supervisor,$employee);
        	}
        }
      return response()->json($flattened);
    }
    private function tree(&$flattened,$supervisor,$employee){
      	foreach ($flattened as $childsupervisor =>  $childemployee) {

      			if($supervisor===$childsupervisor)
      			{
      				$employeeArray=[];
      				$employeeArray[$employee]=[];
      				$flattened[$childsupervisor]=array_merge($flattened[$childsupervisor],$employeeArray);
      				return;
      			}
      			else if($employee===$childsupervisor)
      			{

      				$employeeArray=[];
      				$employeeArray[$childsupervisor]=$flattened[$childsupervisor];

      				$flattened[$supervisor]=$employeeArray;

      				unset($flattened[$childsupervisor]);
      				return;

      			}
      			else if(is_array($childemployee) && sizeof($childemployee)>0)
      			{

      				return $this->tree($flattened[$childsupervisor],$supervisor,$employee);

      			}
      		}
      }

}
