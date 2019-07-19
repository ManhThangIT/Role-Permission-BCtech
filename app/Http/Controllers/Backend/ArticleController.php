<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Category;
use App\Models\User;


class ArticleController extends Controller
{
    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepository = $articleRepo;
    }

    /**
     * Display a listing of the Article.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->articleRepository->pushCriteria(new RequestCriteria($request));
        $articles = $this->articleRepository->all();

        // dd($U->name);

        return view('backend.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new Article.
     *
     * @return Response
     */
    public function create()
    {
        // Category
        $categories = [];
        $getCategories = Category::all();
        // dd($getCategories);
        foreach ($getCategories as $getCategory) {
            $categories[$getCategory->id] = $getCategory->name;
            // dd($categories[$getCategory->id]);
            $children = Category::where('id', $getCategory->id)->get();
            // dd($children);
            foreach ($children as $child) {
                $categories[$child->id] = '|__ ' . $child->name;
                // dd($categories[$child->id]);
                $grandChildren = Category::where('id', $child->id)->get();
                // dd($grandChildren);
                foreach ($grandChildren as $ch) {
                    $categories[$ch->id] = '----- ' . $ch->name . ' -----';
                }
            }
        }
        // dd($categories);
        // User
        $users = [];
        $getUsers = User::all();

        foreach ($getUsers as $getUser) {
            $users[$getUser->id] = $getUser->name;
            $getUse = User::where('id', $getUser->id)->get();
            foreach ($getUse as $getUs) {
                $users[$getUs->id] = '|__ ' . $getUs->name;
                $grandUser = User::where('id', $getUs->id)->get();
                foreach ($grandUser as $U) {
                    $users[$U->id] = '----- ' . $U->name . ' -----';
                }
            }
        }

        return view('backend.articles.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created Article in storage.
     *
     * @param CreateArticleRequest $request
     *
     * @return Response
     */
    public function store(CreateArticleRequest $request)
    {

        request()->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $input = $request->all();

        // $imageName = time().'.'.request()->image->getClientOriginalExtension();

        // request()->image->move(public_path('public/assets/media/image/article'), $imageName);

        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);

            \File::makeDirectory(config('upload.articles') .  date('dm'), 0775, true, true);
            $timestamp = time();
            $image->save(config('upload.articles') .  date('dm') . '/' . "_" . $timestamp . '.' .  $ext);
            $input['image'] = date('dm') . '/' . '_' . $timestamp . '.' .  $ext;
        }


        $article = $this->articleRepository->create($input);

        Flash::success('Article saved successfully.');

        return redirect(route('admin.articles.index', compact('imageName')));
    }

    /**
     * Display the specified Article.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            return redirect(route('admin.articles.index'));
        }

        return view('backend.articles.show')->with('article', $article);
    }

    /**
     * Show the form for editing the specified Article.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // Category
        $categories = [];
        $getCategories = Category::all();
        // dd($getCategories);
        foreach ($getCategories as $getCategory) {
            $categories[$getCategory->id] = $getCategory->name;
            // dd($categories[$getCategory->id]);
            $children = Category::where('id', $getCategory->id)->get();
            // dd($children);
            foreach ($children as $child) {
                $categories[$child->id] = '|__ ' . $child->name;
                // dd($categories[$child->id]);
                $grandChildren = Category::where('id', $child->id)->get();
                // dd($grandChildren);
                foreach ($grandChildren as $ch) {
                    $categories[$ch->id] = '----- ' . $ch->name . ' -----';
                }
            }
        }
        // dd($categories);
        // User
        $users = [];
        $getUsers = User::all();

        foreach ($getUsers as $getUser) {
            $users[$getUser->id] = $getUser->name;
            $getUse = User::where('id', $getUser->id)->get();
            foreach ($getUse as $getUs) {
                $users[$getUs->id] = '|__ ' . $getUs->name;
                $grandUser = User::where('id', $getUs->id)->get();
                foreach ($grandUser as $U) {
                    $users[$U->id] = '----- ' . $U->name . ' -----';
                }
            }
        }

        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            return redirect(route('admin.articles.index'));
        }

        return view('backend.articles.edit', compact('categories', 'users', 'article'));
    }

    /**
     * Update the specified Article in storage.
     *
     * @param  int              $id
     * @param UpdateArticleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticleRequest $request)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            return redirect(route('admin.articles.index'));
        }

        $article = $this->articleRepository->update($request->all(), $id);

        Flash::success('Article updated successfully.');

        return redirect(route('admin.articles.index'));
    }

    /**
     * Remove the specified Article from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            return redirect(route('admin.articles.index'));
        }

        $this->articleRepository->delete($id);

        Flash::success('Article deleted successfully.');

        return redirect(route('admin.articles.index'));
    }
}
