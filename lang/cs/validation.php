<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validační jazykové řádky
    |--------------------------------------------------------------------------
    |
    | Následující jazykové řádky obsahují výchozí chybové zprávy používané
    | validační třídou. Některá z těchto pravidel mají více verzí, jako
    | například pravidla pro velikost. Můžete upravit každou z těchto zpráv.
    |
    */

    'accepted' => 'Pole :attribute musí být akceptováno.',
    'accepted_if' => 'Pole :attribute musí být akceptováno, když :other je :value.',
    'active_url' => 'Pole :attribute musí být platná URL adresa.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'Pole :attribute musí být datum po nebo rovno :date.',
    'alpha' => 'Pole :attribute může obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute může obsahovat pouze písmena, čísla, pomlčky a podtržítka.',
    'alpha_num' => 'Pole :attribute může obsahovat pouze písmena a čísla.',
    'array' => 'Pole :attribute musí být pole.',
    'ascii' => 'Pole :attribute může obsahovat pouze jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'Pole :attribute musí být datum před nebo rovno :date.',
    'between' => [
        'array' => 'Pole :attribute musí mít mezi :min a :max položkami.',
        'file' => 'Pole :attribute musí být mezi :min a :max kilobajty.',
        'numeric' => 'Pole :attribute musí být mezi :min a :max.',
        'string' => 'Pole :attribute musí mít mezi :min a :max znaky.',
    ],
    'boolean' => 'Pole :attribute musí být pravda nebo nepravda.',
    'can' => 'Pole :attribute obsahuje neautorizovanou hodnotu.',
    'confirmed' => 'Potvrzení pole :attribute se neshoduje.',
    'current_password' => 'Heslo je nesprávné.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_equals' => 'Pole :attribute musí být datum rovno :date.',
    'date_format' => 'Pole :attribute musí odpovídat formátu :format.',
    'decimal' => 'Pole :attribute musí mít :decimal desetinných míst.',
    'declined' => 'Pole :attribute musí být odmítnuto.',
    'declined_if' => 'Pole :attribute musí být odmítnuto, když :other je :value.',
    'different' => 'Pole :attribute a :other musí být odlišné.',
    'digits' => 'Pole :attribute musí mít :digits číslic.',
    'digits_between' => 'Pole :attribute musí mít mezi :min a :max číslicemi.',
    'dimensions' => 'Pole :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmí končit jednou z následujících hodnot: :values.',
    'doesnt_start_with' => 'Pole :attribute nesmí začínat jednou z následujících hodnot: :values.',
    'email' => 'Pole :attribute musí být platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končit jednou z následujících hodnot: :values.',
    'enum' => 'Vybraná hodnota pole :attribute je neplatná.',
    'exists' => 'Vybraná hodnota pole :attribute je neplatná.',
    'extensions' => 'Pole :attribute musí mít jednu z následujících přípon: :values.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí mít více než :value položek.',
        'file' => 'Pole :attribute musí být větší než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být větší než :value.',
        'string' => 'Pole :attribute musí mít více než :value znaků.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí mít :value položek nebo více.',
        'file' => 'Pole :attribute musí být větší než nebo rovno :value kilobajtům.',
        'numeric' => 'Pole :attribute musí být větší než nebo rovno :value.',
        'string' => 'Pole :attribute musí mít :value znaků nebo více.',
    ],
    'hex_color' => 'Pole :attribute musí být platná hexadecimální barva.',
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Vybraná hodnota pole :attribute je neplatná.',
    'in_array' => 'Pole :attribute musí existovat v :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platná IP adresa.',
    'ipv4' => 'Pole :attribute musí být platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí být platná IPv6 adresa.',
    'json' => 'Pole :attribute musí být platný JSON řetězec.',
    'lowercase' => 'Pole :attribute musí být malými písmeny.',
    'lt' => [
        'array' => 'Pole :attribute musí mít méně než :value položek.',
        'file' => 'Pole :attribute musí být menší než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být menší než :value.',
        'string' => 'Pole :attribute musí mít méně než :value znaků.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmí mít více než :value položek.',
        'file' => 'Pole :attribute musí být menší než nebo rovno :value kilobajtům.',
        'numeric' => 'Pole :attribute musí být menší než nebo rovno :value.',
        'string' => 'Pole :attribute musí mít :value znaků nebo méně.',
    ],
    'mac_address' => 'Pole :attribute musí být platná MAC adresa.',
    'max' => [
        'array' => 'Pole :attribute nesmí mít více než :max položek.',
        'file' => 'Pole :attribute nesmí být větší než :max kilobajtů.',
        'numeric' => 'Pole :attribute nesmí být větší než :max.',
        'string' => 'Pole :attribute nesmí mít více než :max znaků.',
    ],
    'max_digits' => 'Pole :attribute nesmí mít více než :max číslic.',
    'mimes' => 'Pole :attribute musí být soubor typu: :values.',
    'mimetypes' => 'Pole :attribute musí být soubor typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musí mít alespoň :min položek.',
        'file' => 'Pole :attribute musí mít alespoň :min kilobajtů.',
        'numeric' => 'Pole :attribute musí být minimálně :min.',
        'string' => 'Pole :attribute musí mít alespoň :min znaků.',
    ],
    'min_digits' => 'Pole :attribute musí mít alespoň :min číslic.',
    'missing' => 'Pole :attribute musí chybět.',
    'missing_if' => 'Pole :attribute musí chybět, když :other je :value.',
    'missing_unless' => 'Pole :attribute musí chybět, pokud :other není :value.',
    'missing_with' => 'Pole :attribute musí chybět, když je přítomno :values.',
    'missing_with_all' => 'Pole :attribute musí chybět, když jsou přítomny :values.',
    'multiple_of' => 'Pole :attribute musí být násobkem :value.',
    'not_in' => 'Vybraná hodnota pole :attribute je neplatná.',
    'not_regex' => 'Formát pole :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí být číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovat alespoň jeden symbol.',
        'uncompromised' => 'Zadané :attribute se objevilo v úniku dat. Prosím vyberte jiné :attribute.',
    ],
    'present' => 'Pole :attribute musí být přítomno.',
    'present_if' => 'Pole :attribute musí být přítomno, když :other je :value.',
    'present_unless' => 'Pole :attribute musí být přítomno, pokud :other není :value.',
    'present_with' => 'Pole :attribute musí být přítomno, když je přítomno :values.',
    'present_with_all' => 'Pole :attribute musí být přítomno, když jsou přítomny :values.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když :other je :value.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje, aby bylo přítomno :other.',
    'regex' => 'Formát pole :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovat záznamy pro: :values.',
    'required_if' => 'Pole :attribute je povinné, když :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, když je :other akceptováno.',
    'required_unless' => 'Pole :attribute je povinné, pokud :other není v :values.',
    'required_with' => 'Pole :attribute je povinné, když je přítomno :values.',
    'required_with_all' => 'Pole :attribute je povinné, když jsou přítomny :values.',
    'required_without' => 'Pole :attribute je povinné, když není přítomno :values.',
    'required_without_all' => 'Pole :attribute je povinné, když nejsou přítomny žádné z :values.',
    'same' => 'Pole :attribute musí odpovídat :other.',
    'size' => [
        'array' => 'Pole :attribute musí obsahovat :size položek.',
        'file' => 'Pole :attribute musí mít :size kilobajtů.',
        'numeric' => 'Pole :attribute musí být :size.',
        'string' => 'Pole :attribute musí mít :size znaků.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jednou z následujících hodnot: :values.',
    'string' => 'Pole :attribute musí být řetězec.',
    'timezone' => 'Pole :attribute musí být platná časová zóna.',
    'unique' => 'Pole :attribute již existuje.',
    'uploaded' => 'Nepodařilo se nahrát :attribute.',
    'uppercase' => 'Pole :attribute musí být velkými písmeny.',
    'url' => 'Pole :attribute musí být platná URL adresa.',
    'ulid' => 'Pole :attribute musí být platný ULID.',
    'uuid' => 'Pole :attribute musí být platný UUID.',

    /*
    |--------------------------------------------------------------------------
    | Vlastní validační zprávy
    |--------------------------------------------------------------------------
    |
    | Zde můžete specifikovat vlastní validační zprávy pro atributy pomocí
    | konvence "attribute.rule" pro pojmenování řádků. To umožňuje rychle
    | specifikovat specifickou vlastní jazykovou řádku pro dané pravidlo.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Vlastní názvy atributů
    |--------------------------------------------------------------------------
    |
    | Následující jazykové řádky se používají k záměně zástupných symbolů
    | atributů za něco čitelnějšího, jako "E-mailová adresa" místo "email".
    | To nám jednoduše pomáhá učinit zprávy výraznějšími.
    |
    */

    'attributes' => [
        'firstname' => 'jméno',
        'lastname' => 'příjmení',
        'name' => 'jméno',
        'surname' => 'příjmení',
        'company' => 'firma',
        'email' => 'e-mail',
        'phone' => 'telefon',
        'prefix' => 'předvolba',
        'field' => 'oblast',
        'message' => 'zpráva',
        'content' => 'obsah',
        'cv' => 'životopis',
        'motivation' => 'motivační dopis',
        'dob' => 'datum narození',
        'country' => 'země',
        'city' => 'město',
        'street' => 'ulice',
        'zip' => 'PSČ',
        'job' => 'povolání',
        'password' => 'heslo',
        'passwordAgain' => 'heslo znovu',
    ],

];
