<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use App\Models\News;
use Auth;
use PDF;
use App\Traits\NewsTrait;

\DB::connection()->enableQueryLog();


class NewsController extends Controller
{
     use NewsTrait;
     
    /* save news
     * @param request object $request
     * @return mixed
     */
    public function saveNews(Request $request) {
        
        $this->validate($request, [
                                    'title' => 'required',
                                    'description' => 'required'
                                    ]
                    );
    
        $pathToSave = '';
        if(isset($request->file)) {
            //validate file
            $file   =   $request->file;
            $maxSize = config('app.maxUploadSize');
        	$originalExt = strtolower($file->getClientOriginalExtension());
            $ext = (!$originalExt) ? strtolower($file->guessExtension()): $originalExt;
			$attachExt = (!$originalExt) ? ".".$ext : "";
            $validExt = array('jpg', 'jpeg', 'png', 'gif');
            $msg = '';
            if(!in_array($ext, $validExt)) {
				$msg =  "Allowed filetypes : ".implode(',', $validExt);
			}
			//get size validation
			if($maxSize < $file->getSize()) {//bytes
				$msg = "Cannot upload large file";
			}
            if($msg) {
                return back()->withInput()->with('newsMsg', $msg);
            }
		    //save to folder
            try {
                $pathToSave = \App\Models\FileUpload::uploadFileAndThumbnail($file);    
            } catch (Exception $e) {
                return back()->withInput()->with('newsMsg', "Cannot upload file");
            }
        }    

        
         //save to news table
        try {
            $newsObj                =   app()->make('App\Models\News');
            $newsObj->user_id       =   Auth::user()->id;
            $newsObj->title         =   $request->get('title');
            $newsObj->description   =   $request->get('description');
            $newsObj->filepath      =   $pathToSave;
            $newsObj->slug          =   $this->generateSlug($request->get('title'));
            $newsObj->status        =   'active';
            $newsObj->created_at    =   date("Y-m-d H:i:s");
            $newsObj->save();
            //redirect to listing
            return redirect()->route('dashboard')->with('newsSuccessMsg', 'News published successfully');    
        } catch (Exception $e) {
              //echo $e->getMessage();die;
            return back()->withInput()->with('newsMsg', "News save error");
        }
    }
    
    /* delete news
     * @param request object $request
     * @return mixed
     */
    public function deleteNews(Request $request) {
        $this->validate($request, [
                                    'newsId' => 'required'
                                    ]
                    );
        $newsObj = News::find($request->get("newsId"));
        
        $msg = ['newsMsg'=> "Invalid"];
        //if logged in user and owner user id same then delete
        if($newsObj && $newsObj->user_id == Auth::user()->id) {
            try {
                $newsObj->delete();
                $msg = ['newsSuccessMsg'=>"News deleted successfully"];
            } catch (Exception $e) {
                $msg = ['newsMsg'=>"Error in delete"];
            }
        }
        return back()->withInput()->with($msg);
    }
    
    /*  show news article
     *  @param string $slug
     *  @return view
     */
    public function showNews(Request $request, $slug) {
        $news = News::where('slug', 'like', '%'.$slug.'%')->first();
        return View("layouts.news", compact('news'));
    }
    
    /*  Dowload news article
     *  @param string $slug
     *  @return pdf file to download
     */
    
    public  function downloadNews(Request $request, $slug) {
        $news = News::where('slug', 'like', '%'.$slug.'%')->first();
        
        //generate pdf
        $pdf = app()->make('dompdf.wrapper');
        $pdfObj = $pdf->loadView('pdf.news', ["news"=>$news]);
        return $pdfObj->download('news.pdf');

    }
    
    /*  show newsstand,get latest news
     *  @return view
     */
    public function newsStandShow(Request $request) {
        //get latest 10 news
        $newsList    =   $this->latestNews();
        return View("layouts.newsstand", compact('newsList'));

    }
    
    /*  show latest new for rss
     *  @return view
     */
    public function newsRss(Request $request) {
        // create new feed
        $feed = app()->make("feed");
    
        $feed->setCache(60);
    
        // check if there is cached feed and build new only if is not
        if (!$feed->isCached())
        {
           //get latest 10 news
           $posts    =   $this->latestNews();
           if(!$posts->count()) {
                return View("layouts.newsstand", ['newsList'=>$posts]);
           }
           // set your feed's title, description, link, pubdate and language
           $feed->title = 'My News Feeds';
           $feed->description = 'News management by Rajesh';

           $feed->link = url('feed');
           $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
           $feed->pubdate = $posts[0]->created_at;
           $feed->lang = 'en';
           $feed->setShortening(true); // true or false
           $feed->setTextLimit(100); // maximum length of description text
    
           foreach ($posts as $post)
           {
               // set item's title, author, url, pubdate, description, content, enclosure (optional)*
               $feed->add($post->title, $post->user->name, route('newsdetail', $post->slug), $post->created_at, $post->description, '');
           }
    
        }
        return $feed->render('atom');

    }
}
