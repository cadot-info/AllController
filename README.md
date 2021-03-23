# AllController
Universal Controller for symfony 5


## Use
0- copy AllController in   Controller directory and all in templates
1- create yours entities (name with fisrt letter in capitalize)=>Word
2- create crud by make:crud, remove the controllers created and template directory
2- add your repository in construct and import all classes
 protected $word;

    public function __construct(WordRepository $word)
    {
        $this->word = $word;
    }
 enjoy

## Optionnal
add protect for your routes
 * @IsGranted("ROLE_SUPER_ADMIN")


menu example .....=entity name in minuscule
 <a class="nav-link" href="{{path('all_index',{'part':'.........'})}}">texte</a>