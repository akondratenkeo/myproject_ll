<?php

use App\Frontend\Models\Topic;
use App\Frontend\Models\Author;
use App\Frontend\Models\Article;
use App\Frontend\Models\Image;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    protected const N_TOPICS = 30;

    protected const N_AUTHORS = 5000;

    protected const N_ARTICLES = 500000;

    /**
     * @var int
     */
    protected $batchStep = 500;

    /**
     * @var \Faker\Factory
     */
    protected $faker;

    /**
     * DatabaseSeeder constructor.
     *
     * @param FakerFactory $faker
     */
    public function __construct(FakerFactory $faker)
    {
        $this->faker = $faker::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        Capsule::table('topics')->insert($this->generateTopics(self::N_TOPICS));

        $i = self::N_AUTHORS;
        while ($i > 0) {
            $step = ($i < $this->batchStep) ? $i : $this->batchStep;

            if (Capsule::table('authors')->insert($this->generateAuthors($step))) {
                $i -= $step;
            }
        }

        $i = self::N_ARTICLES;
        while ($i > 0) {
            $step = ($i < $this->batchStep) ? $i : $this->batchStep;

            if (Capsule::table('articles')->insert($this->generateArticles($step, self::N_TOPICS, self::N_AUTHORS))) {
                $i -= $step;
            }
        }

        $image = $this->faker->image(
            $this->container['path.var'].DIRECTORY_SEPARATOR.'storage',
            1110,
            420,
            'cats',
            false
        );

        $i = 1;
        while ($i <= self::N_ARTICLES) {

            if (Capsule::table('images')->insert($this->generateImages($image, $i, $this->batchStep))) {
                $i += $this->batchStep;
            }
        }
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    protected function &generateTopics(int $limit) : array
    {
        $topics = [];

        for ($i = 0; $i < $limit; $i++) {
            $topics[$i] = [
                'title' => $this->faker->unique()->streetName,
                'created_at' => $this->faker->dateTimeInInterval($startDate = '-4 years', $interval = '-2 years'),
            ];
        }

        return $topics;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    protected function &generateAuthors(int $limit) : array
    {
        $authors = [];

        for ($i = 0; $i < $limit; $i++) {
            $authors[$i] = [
                'name' => $this->faker->unique()->name,
                'created_at' =>  $this->faker->dateTimeInInterval($startDate = '-4 years', $interval = '-2 years'),
            ];
        }

        return $authors;
    }

    /**
     * @param int $limit
     * @param int $nTopics
     * @param int $nAuthors
     *
     * @return array
     */
    protected function &generateArticles(int $limit, int $nTopics, int $nAuthors) : array
    {
        $articles = [];
        static $dates = [];

        if (! count($dates)) {
            for ($i = 1; $i <= 3000; $i++) {
                $dates[$i] = $this->faker->unique()->dateTimeThisYear();
            }

            unset($i);
        }

        $description = $this->faker->text(196);
        $body = $this->faker->realText(4096);

        for ($i = 0; $i < $limit; $i++) {
            $datetime = $dates[mt_rand(1, 3000)];

            $articles[$i] = [
                'topic_id' => mt_rand(1, $nTopics),
                'author_id' => mt_rand(1, $nAuthors),
                'title' => $this->faker->sentence(5),
                'description' => $description,
                'body' => $body,
                'visited' => 1,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ];
        }

        return $articles;
    }

    protected function &generateImages(string $image, int $offset, int $limit) : array
    {
        $images = [];

        for ($i = 0; $i < $limit; $i++) {
            $images[$i] = [
                'article_id' => $offset + $i,
                'filename' => $image,
            ];
        }

        return $images;
    }
}
