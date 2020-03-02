<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Elements as ElementsModel;
use app\index\model\Rules as RulesModel;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function studyElement(Request $request){
        $elements = new ElementsModel;
        $elements->name = $request->param("name");
        $elements->definition = $request->param('definition');
        if($elements->save()){
            return $elements->id;
        }else{
            return $elements->getError();
        }
    }

    public function testElement(Request $request){
        $name = $request->param('name');
        $var = $request->param('teststr');
        $data = ElementsModel::get(['name'=>$name]);
        $definition = $data->definition;
        return eval($definition);
    }

    public function studyRule(Request $request){
        $rule = new RulesModel;
        $rule->name = $request->param("name");
        $rule->definition = $request->param('definition');
        $rule->verification = $request->param('verification');
        if($rule->save()){
            return $rule->id;
        }else{
            return $rule->getError();
        }
    }

    public function testRule(Request $request){
        $name = $request->param("name");
        $var = $request->param("teststr");
        $data = RulesModel::get(['name'=>$name]);
        $regex = $data->verification;
        $matches = array();
        if(preg_match($regex, $var, $matches)){
            $var = "return " . $var . ";"; 
            return eval($var);
        }else{
            return "no match!";
        }
    }

    public function hello($id = 0){
        return $id;
    }
}
