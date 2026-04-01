<?php

namespace App\Services\System;

use App\Interfaces\System\SitemapItem;
use Illuminate\Support\Str;

class SeoService
{
    public static function generateSitemapsFile(array $modelsToGenerate, string $locale): bool{
        $fileItemsContent = '';

        foreach ($modelsToGenerate as $model){
            /* @var $modelInstance SitemapItem */
            $modelInstance = new $model;

            if (in_array(SitemapItem::class,class_implements($modelInstance))){
                $items = $modelInstance->getItemsForSitemap($locale);

                if ($items){
                    foreach ($items as $item){
                        $name = $item->getNameForSitemap();
                        $url = Str::startsWith($name, ['http://','https://'])
                            ? $name
                            : rtrim(config('app.url'),'/').'/'.ltrim($name,'/');
                        $fileItemsContent .= self::createSitemapItem($url);
                    }
                }
            }else{
                echo '<br> Interface sitemapItem not implemented in '.$model;
            }
        }

        if ($fileItemsContent){
            return self::createSitemapFile($fileItemsContent,'sitemap');
        }

        return false;
    }

    private static function createSitemapItem(string $url, bool $addLastMod=true):string{
        $xmlItemStr = '<url><loc>'.$url.'</loc>';

        if ($addLastMod){
            $xmlItemStr .= '<lastmod>'.date('Y-m-d').'</lastmod>';
        }

        return $xmlItemStr.'</url>';
    }

    private static function createSitemapFile(string $content, string $name): bool{
        $finalXmlContent = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
          '.$content.'
        </urlset>';

        if (file_put_contents(public_path().'/'.$name.'.xml',$finalXmlContent)) {
            return true;
        }

        return false;
    }

    public static function writeToRobotsTxt(string $content):bool{
        if (file_put_contents(public_path().'/robots.txt',$content)) {
            return true;
        }

        return false;
    }
}
