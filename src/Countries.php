<?php

namespace Lykegenes\LaravelCountries;

class Countries
{
    /**
     * The column constants.
     */
    const ISO3166_ALPHA_2 = 'cca2';
    const ISO3166_ALPHA_3 = 'cca3';
    const ISO3166_NUMERIC_3 = 'ccn3';
    const REGION = 'region';
    const SUBREGION = 'subregion';

    /**
     * The regions constants.
     */
    const AFRICA = 'Africa';
    const AMERICAS = 'Americas';
    const ASIA = 'Asia';
    const EUROPE = 'Europe';
    const OCEANIA = 'Oceania';
    const NO_REGION = '';

    /**
     * Dependencies paths
     */
    protected $prod_path = __DIR__.'/../../../mledoze/countries/dist/countries-unescaped.json';
    protected $dev_path = __DIR__.'/../vendor/mledoze/countries/dist/countries-unescaped.json';

    protected $data = [];

    public function __construct()
    {
        if (file_exists($this->prod_path)){
            $this->data = json_decode(file_get_contents($this->prod_path), true);
        } else if (file_exists($this->dev_path)){
            $this->data = json_decode(file_get_contents($this->dev_path), true);
        } else {
            return;
        }
    }

    public function getByAlpha2Code($code)
    {
        return $this->searchSingleItemByColumn(self::ISO3166_ALPHA_2, $code);
    }

    public function getByAlpha3Code($code)
    {
        return $this->searchSingleItemByColumn(self::ISO3166_ALPHA_3, $code);
    }

    public function getByNumericCode($code)
    {
        return $this->searchSingleItemByColumn(self::ISO3166_NUMERIC_3, $code);
    }

    public function getByRegion($region)
    {
        return $this->searchMultipleItemsByColumn(self::REGION, $region);
    }

    public function getBySubregion($subregion)
    {
        return $this->searchMultipleItemsByColumn(self::SUBREGION, $subregion);
    }

    protected function searchSingleItemByColumn($columnKey, $input)
    {
        $key = array_search($input, array_column($this->data, $columnKey));

        return $this->data[$key];
    }

    public function searchMultipleItemsByColumn($columnKey, $input)
    {
        $keys = array_flip(array_keys(array_column($this->data, $columnKey), $input));

        return array_intersect_key($this->data, $keys);
    }

    public function getRawData()
    {
        return $this->data;
    }
}
