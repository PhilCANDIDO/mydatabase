<?php

namespace App\Traits;

trait FormatsAttributes
{
    /**
     * Formater un attribut pour l'affichage
     *
     * @param mixed $value La valeur à formater
     * @param string|null $glue Le séparateur pour les tableaux
     * @return string
     */
    protected function formatAttributeValue($value, $glue = ', ')
    {
        if (is_null($value)) {
            return '';
        }
        
        if (is_array($value)) {
            return implode($glue, array_filter($value, function ($item) {
                return !is_null($item) && $item !== '';
            }));
        }
        
        if (is_bool($value)) {
            return $value ? __('Oui') : __('Non');
        }
        
        return (string) $value;
    }
    
    /**
     * Obtenir les attributs formatés pour l'affichage
     *
     * @return array
     */
    public function getFormattedAttributes()
    {
        $formattedAttrs = [];
        
        foreach ($this->getFormatableAttributes() as $attr) {
            $method = 'getFormatted' . str_replace('_', '', ucwords($attr, '_')) . 'Attribute';
            
            if (method_exists($this, $method)) {
                $formattedAttrs[$attr] = $this->{$method}();
            } else {
                $formattedAttrs[$attr] = $this->formatAttributeValue($this->{$attr});
            }
        }
        
        return $formattedAttrs;
    }
    
    /**
     * Définit les attributs qui doivent être formatés
     * À surcharger dans les classes qui utilisent ce trait
     *
     * @return array
     */
    protected function getFormatableAttributes()
    {
        return [];
    }
}