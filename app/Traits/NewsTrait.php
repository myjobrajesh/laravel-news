<?php
namespace App\Traits;

use App\Models\News;

trait NewsTrait {


   /*   get last slug
    *   @param string $slug
    *   @param integer $id - optional
    *   @return object
    */
    public function getLastSlug($slug, $id=null) {
        $obj = News::where('slug', 'like', '%'.$slug.'%');
        if($id) {
            $obj->where('id', '!=', $id);
        }
        return $obj->orderBy('id', 'desc')->first(['id', 'slug']);
    }

    /*  get news by slug
    *   @param string $slug
    *   @return object
    */   
    public function getBlogBySlug($slug) {
        return News::where('status', '=', 'active')->where('slug', '=', ''.$slug.'')->first();
    }
    
    
    /* get the unique slug to  save into db
     * 
     *   @param string $slug
     *   @param integer $id - optional
     *   @return string
	 */
	public function generateSlug($title, $id=null) {
		$slug = str_slug(strip_tags($title));
		$slugStr = $slug;
		$exists = $this->getLastSlug($slugStr, $id);
		$slugStr = substr($slugStr, 0, 100);//limit to 100 chars
		if($exists) {
			$slugStr .='-'.$exists->id;
		}
		return $slugStr;
	}
    
    /* get latest 10 news
     * @param integer $limit
     * @return collection of object
     */
    public function latestNews($limit = 10) {
        return News::where('status', 'active')->orderBy('created_at', 'DESC')->take($limit)->get();
    }
}