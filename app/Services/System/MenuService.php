<?php

namespace App\Services\System;

use App\Helpers\PageTypesHelper;
use App\Models\System\Page;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    public static function getMenu(): Collection|array{
        return Page::query()
            ->where('lang_locale','=',app()->currentLocale())
            ->where('active','=',1)
            ->where('in_menu','=',1)
            ->orderBy('in_menu_order')
            ->get();
    }

    public static function getFooterMenu(): Collection|array{
        return Page::query()
            ->where('lang_locale','=',app()->currentLocale())
            ->where('active','=',1)
            ->where('in_footer_menu','=',1)
            ->orderBy('in_menu_order')
            ->get();
    }

    public static function getFooterMenuForLogged(): Collection|array{
        return Page::query()
            ->where('lang_locale','=',app()->currentLocale())
            ->where('active','=',1)
            ->where('in_menu_only_for_logged','=',1)
            ->orderBy('in_menu_order')
            ->get();
    }

    public static function getMenuNested(): ?array{
        $menuItems = self::getMenu();

        if ($menuItems){
            $ret = [];

            foreach ($menuItems as $item){
                if ($item->parent_id){
                    if (!isset($ret[$item->parent_id])){
                        $ret[$item->parent_id] = [
                            'subItems'=>[]
                        ];
                    }
                    $ret[$item->parent_id]['subItems'][] = $item;
                }else{
                    if (isset($ret[$item->id]['subItems']) && !isset($ret[$item->id]['main'])){
                        $subItemsTemp = $ret[$item->id]['subItems'];
                        $ret[$item->id] = ['subItems'=>$subItemsTemp,'main'=>$item];
                    }else{
                        $ret[$item->id] = ['subItems'=>[],'main'=>$item];
                    }

                    if (isset(PageTypesHelper::$loadSubDataToMenuForTypes[$item->type])){
                        $modelForSubItems = PageTypesHelper::$loadSubDataToMenuForTypes[$item->type]::query()
                            ->where('lang_locale','=',app()->currentLocale())
                            ->where('active','=',1)
                            ->get();

                        if ($modelForSubItems){
                            foreach ($modelForSubItems as $subItem){
                                $ret[$item->id]['subItems'][] = $subItem;
                            }
                        }
                    }
                }
            }

            return $ret;
        }

        return null;
    }

    public static function getMenuTree(): array{
        $menuItems = self::getMenu();
        return self::buildTree($menuItems->toArray());
    }

    private static function buildTree(array $dataset): array{
        $tree = [];
        $references = [];
        foreach ($dataset as $id => &$node) {
            $references[$node['id']] = &$node;
            $node['subItems'] = [];

            if (is_null($node['parent_id'])) {
                $tree[$node['id']] = &$node;
            } else {
                $references[$node['parent_id']]['subItems'][$node['id']] = &$node;
            }
        }

        return $tree;
    }

}
