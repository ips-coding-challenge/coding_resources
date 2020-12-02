<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\User;
use App\Models\Langue;
use App\Models\Article;
use App\Models\Category;
use App\Models\Conference;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Tuto;
use App\Models\TutoPart;

class CopyDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:database {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy the local db to online db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // if ($this->argument('table') === 'users') {
        //     $this->copyUsers();
        // }


        // if ($this->argument('table') === 'langues') {
        //     $this->copyLangues();
        // }

        // if ($this->argument('table') === 'categories') {
        //     $this->copyCategories();
        // }

        // if ($this->argument('table') === 'articles') {
        //     $this->copyArticles();
        // }

        // if ($this->argument('table') === 'conferences') {
        //     $this->copyConferences();
        // }
        // if ($this->argument('table') === 'books') {
        //     $this->copyBooks();
        // }

        // if ($this->argument('table') === 'tutos') {
        //     $this->copyTutos();
        // }

        // if ($this->argument('table') === 'taggables') {
        //     $this->copyTaggables();
        // }

        if ($this->argument('table') === 'tutosParts') {
            $this->copyTutoParts();
        }
    }

    private function copyUsers()
    {
        // $users = User::all()->toArray();
        $user = DB::table('users')->where('id', 2)->get()[0];
        DB::connection('pgsql')->table('users')->insert([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'role' => $user->role
        ]);
    }

    private function copyLangues()
    {
        // $users = User::all()->toArray();
        $langues = Langue::all()->toArray();
        // dd($langues);
        DB::connection('pgsql')->table('langues')->insert($langues);
    }

    private function copyCategories()
    {
        $categories = Category::all()->toArray();
        DB::connection('pgsql')->table('categories')->insert($categories);
    }

    private function copyArticles()
    {
        $articles = Article::all()->toArray();
        DB::connection('pgsql')->table('articles')->insert($articles);
    }

    private function copyConferences()
    {
        $conferences = Conference::all()->toArray();
        DB::connection('pgsql')->table('conferences')->insert($conferences);
    }

    private function copyBooks()
    {
        $books = Book::all()->toArray();
        DB::connection('pgsql')->table('books')->insert($books);
    }

    private function copyTutos()
    {
        $tutos = Tuto::all()->toArray();
        DB::connection('pgsql')->table('tutos')->insert($tutos);
    }

    private function copyTaggables()
    {
        $taggables = collect(DB::table('taggables')->get()->toArray());

        $final = [];

        $taggables->map(function ($t) {
            $toInsert = [
                'id' => $t->id,
                'category_id' => $t->category_id,
                'taggable_id' => $t->taggable_id,
                'taggable_type' => $t->taggable_type
            ];
            DB::connection('pgsql')->table('taggables')->insert($toInsert);
        });

    }

    private function copyTutoParts()
    {
        $tutosParts = TutoPart::all()->toArray();

        // dd($tutosParts[0]);
        DB::connection('pgsql')->table('tuto_parts')->insert($tutosParts);
    }
}
