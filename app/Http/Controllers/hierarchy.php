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

    public function bonus(Request $request){
      $flattened=[];
      $loop=FALSE;
      foreach ($request->all() as $employee => $supervisor) {
      	if($this->findKey($flattened,$supervisor) && $this->findKey($flattened,$employee))
      	{
      		$loop=TRUE;
      		break;
      	}

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
      if($loop)
      {
        return "{\"error\":true,\"message\":\"either loop found or not unique names\"}";
      }
      else{
      return response()->json($flattened);
      }

    }
    private function findKey($array, $keySearch)
    {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            } elseif (is_array($item) && $this->findKey($item, $keySearch)) {
                return true;
            }
        }
        return false;
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
