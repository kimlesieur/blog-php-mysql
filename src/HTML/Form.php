<?php
namespace App\HTML;

class Form {

    private $objet;
    private $errors;

    public function __construct($objet, array $errors)
    {
        $this->objet = $objet;
        $this->errors = $errors;
    }

    /**
     * @param string|array $key Représente le nom du champ MySQL à récupérer 
     * @param string $label
     * 
     * @return string renvoi le code HTML pour un champ input du formulaire
     */
    public function input(string|array $key, string $label): string
    { 
        //Récupère la valeur du champ à partir du getter ou de la clé si c'est un array qui est passé 
        $value = $this->getValue($key);
        return <<<HTML
          <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}">{$value}</textarea>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    /**
     * @param string|array $key Représente le nom du champ MySQL à récupérer
     * @param string $label
     * 
     * @return string renvoi le code HTML pour un champ textarea du formulaire
     */
    public function textarea(string|array $key, string $label): string
    {
        $value = $this->getValue($key);
        return <<<HTML
          <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    /**
     * @param string|array $key
     * 
     * @return string
     */
    public function getValue(string|array $key): ?string
    {
        //Si c'est un array, retourne directement la valeur en fonction de la clé donnée dans l'array
        if (is_array($this->objet)) {
            return $this->objet[$key] ?? null;
        }
        //Si c'est une string, applique une méthode pour obtenir les noms des getters "getName(), getSlug()..."
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->objet->$method(); 
        //Cas particulier pour date, doit formater pour MySQL
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    /**
     * @param string $key
     * 
     * @return string valeur de la classe CSS à utiliser si y a erreurs présentes ou non
     */
    public function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorFeedback (string $key): string
    {
        if (isset($this->errors[$key])) {
            return '<div class="invalid-feedback">' . implode('<br>', $this->errors[$key]) . '</div>';
        }
        return '';
    }

}