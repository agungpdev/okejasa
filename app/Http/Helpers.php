<?php

use Illuminate\Support\Facades\DB;

class HelperMenu{

    private static function getSubMenu($id){

        $newprop=[];
        $submenu = DB::table('submenu')->where('menu_id',$id)->where('is_active',1)->get();

        foreach ($submenu as $sub) {
            if ($sub->menu_id == $id) {
                $newsub=[];
                $newsub['id']=$sub->id;
                $newsub['menu_id']=$sub->menu_id;
                $newsub['submenu']=$sub->submenu;
                $newsub['is_active']=$sub->is_active;
                $routesub=explode('%',$sub->route);
                $newsub['route']=$routesub[1];
                $newsub = (object) $newsub;
                $newprop[] = $newsub;
            }
        }

        return $newprop;
    }

    public static function getMenu(){

        $menu = DB::table('menu')->where('is_active',1)->get();
        $result=[];

        foreach ($menu as $key => $value) {
            $currentMenu =[];
            $currentMenu['id']=$value->id;
            $currentMenu['menu']=$value->menu;
            $currentMenu['menu_active']=$value->is_active;
            $currentMenu['icon']=$value->icon;

            if($value->route){
                $routemenu=explode('%',$value->route);
                $currentMenu['route']=$routemenu[1];
            }else{
                $currentMenu['route']=$value->route;
            }

            if($value->route_group){
                $routegroup=explode('%',$value->route_group);
                $routegroup=explode('/',$routegroup[1]);
                if(count($routegroup)<=2){
                    $routegroup = implode('/',$routegroup);
                    $routegroup = $routegroup.'/*';
                }else{
                    $routegroup=array_slice($routegroup,0,count($routegroup)-1);
                    $routegroup=implode('/',$routegroup);
                    $routegroup = $routegroup.'/*';
                }
                $currentMenu['group'] = $routegroup;
            }else{
                $currentMenu['group']=null;
            }

            $submenu = self::getSubMenu($value->id);
            $newmenu = ['submenu'=>$submenu];
            $newmenu = (object) array_merge($currentMenu,$newmenu);
            $result[]=$newmenu;
        }
        return $result;
    }

}
