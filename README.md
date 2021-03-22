# AllController
Universal Controller for symfony 5


## Use
0- in your Controller directory clone this github
1- create yours entities (name with fisrt letter in capitalize)=>Word
2- copy all directory in your template directory
2- add your repository in header
example: use App\Repository\WordRepository;

create your construct
 protected $word;

    public function __construct(WordRepository $word)
    {
        $this->word = $word;
    }
 enjoy

## Optionnal
add protect for your routes
 * @IsGranted("ROLE_SUPER_ADMIN")
 * 