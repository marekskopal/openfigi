<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Enum;

enum MappingValuesKeyEnum: string
{
    case IdType = 'idType';
    case ExchCode = 'exchCode';
    case MicCode = 'micCode';
    case Currency = 'currency';
    case MarketSecDes = 'marketSecDes';
    case SecurityType = 'securityType';
    case SecurityType2 = 'securityType2';
    case OptionType = 'optionType';
    case StateCode = 'stateCode';
}
