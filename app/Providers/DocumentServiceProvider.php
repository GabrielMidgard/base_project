<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Document;
use Illuminate\Support\Facades\Storage;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     *Metodo para subir imagenes
     *
     *@param $doc -> documento enviado en la peticion
     *@param $disk -> Disco en el que sera guardado
     *
     *@return id del documento guardado en la base de datos
     *
     */
    public static function save($doc,$disk='public')
    {
        $doc_path=Storage::disk($disk)->putFile('docs', $doc);

        $doc=new Document(array(
            "path"=>$doc_path,
            "disk"=>$disk,
            "key"=>uniqid(),
        ));

        $doc->save();

        return $doc->id;
    }

    /**
     *Metodo para eliminar una imagen
     *
     *@param $doc_id -> id del documento guardado en la base de datos
     *
     *@return verdadero o falso
     *
     */
    public static function delete($doc_id)
    {
        $old_doc=Document::find($doc_id);
        //Lo borramos del servidor
        Storage::disk($old_doc->disk)->delete($old_doc->path);
        //Lo borramos de la base de datos
        if ($old_doc->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     *Metodo para obtener una imagen
     *
     *@param $doc_id -> id del documento guardado en la base de datos
     *
     *@return Datos del documento
     *
     */
    public static function get($doc_id)
    {
        $doc=Document::find($doc_id);
        return $doc;
    }

    /**
     *Metodo para obtener la ruta real del documento
     *
     *@param $key -> Llave del documento en la base de datos
     *
     *@return url real del documento
     *
     */
    public static function getPath($key)
    {
        $doc=Document::where("key",$key)->first();
        $url=Storage::disk($doc->disk)->getDriver()->getAdapter()->applyPathPrefix($doc->path);
        return $url;
    }

    /**
     *Metodo para url publica del documento
     *
     *@param $doc_id -> id del documento guardado en la base de datos
     *
     *@return url publica del documento (visitable)
     *
     */
    public static function getUrl($doc_id)
    {
        $doc=Document::find($doc_id);
        if(empty($doc))
            return "";
        else
            return url("/docs/".$doc->key);
    }

    /**
     *Metodo para obtener etiqueta html del documento
     *
     *@param $doc_id -> id del documento guardada en la base de datos
     *
     *@return etiqueta html con el documento
     *
     */
    public static function getLink($doc_id)
    {
        $doc=self::get($doc_id);
        $url=self::getUrl($doc_id);
        // var_dump($doc);
        if($doc){
            $link="<a href='".$url."' target='_blank'>".$doc->key."</a>";
        }
        else{
            $link=null;
        }
        return $link;
    }

    public static function getExt($doc_id)
    {
        $doc=self::get($doc_id);
        $arr=explode('.',$doc->path);

        return $arr[count($arr)-1];
    }

}
