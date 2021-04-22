<?php
declare(strict_types=1);

namespace LosI18n\Service;

final class CountryService
{
    private $defaultLang;
    private $path;

    /**
     * CountryService constructor.
     * @param string $path
     * @param string $defaultLang
     */
    public function __construct(string $path, string $defaultLang)
    {
        $this->path = $path;
        $this->defaultLang = $defaultLang;
    }

    /**
     * Returns all countries. If needed it can return only officially assigned ones by passing second parameter as true.
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements
     *
     * @param string $translatedTo
     * @param bool $filterOfficiallyAssigned
     * @return array
     */
    public function getAllCountries(string $translatedTo = '', bool $filterOfficiallyAssigned = true): array
    {
        if ('' === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/countries.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $countries = include $fileName;

        if ($filterOfficiallyAssigned) {
            $filterKeys = ['AF','AX','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BV','BR','IO','VG','BN','BG','BF','BI','KH','CM','CA','CV','KY','CF','TD','CL','CN','CX','CC','CO','KM','CK','CR','HR','CU','CW','CY','CZ','CD','DK','DJ','DM','DO','TL','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','TF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HM','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IM','IL','IT','CI','JM','JP','JE','JO','KZ','KE','KI','XK','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ','MM','NA','NR','NP','NL','NC','NZ','NI','NE','NG','NU','NF','KP','MP','NO','OM','PK','PW','PS','PA','PG','PY','PE','PH','PN','PL','PT','PR','QA','CG','RE','RO','RU','RW','BL','SH','KN','LC','MF','PM','VC','WS','SM','ST','SA','SN','RS','SC','SL','SG','SX','SK','SI','SB','SO','ZA','GS','KR','SS','ES','LK','SD','SR','SJ','SZ','SE','CH','SY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','VI','UG','UA','AE','GB','US','UM','UY','UZ','VU','VA','VE','VN','WF','EH','YE','ZM','ZW']; // @ignoreCodingStandards
            $countries = array_intersect_key($countries, array_flip($filterKeys));
        }

        return $countries;
    }

    /**
     * @param string $country
     * @param string $translatedTo
     * @return mixed
     */
    public function getCountry(string $country, string $translatedTo = '')
    {
        if ('' === $translatedTo) {
            $translatedTo = $this->defaultLang;
        }
        $fileName = $this->path.'/'.$translatedTo.'/countries.php';
        if (! file_exists($fileName)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }

        $list = include $fileName;
        if (! is_array($list)) {
            throw new \InvalidArgumentException("Language $translatedTo not found.");
        }
        $country = strtoupper($country);
        if (! array_key_exists($country, $list)) {
            throw new \InvalidArgumentException("Country $country not found for $translatedTo.");
        }

        return $list[$country];
    }
}
