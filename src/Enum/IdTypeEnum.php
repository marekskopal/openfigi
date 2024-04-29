<?php

declare(strict_types=1);

namespace MarekSkopal\OpenFigi\Enum;

enum IdTypeEnum: string
{
    case Isin = 'ID_ISIN';
    case UniqueBloombergIdentifier = 'ID_BB_UNIQUE';
    case SedolNumber = 'ID_SEDOL';
    case CommonCode = 'ID_COMMON';
    case Wertpapierkennnummer = 'ID_WERTPAPIER';
    case Cusip = 'ID_CUSIP';
    case Cins = 'ID_CINS';
    case LegacyBloombergIdentifier = 'ID_BB';
    case LegacyBloombergIdentifier8Character = 'ID_BB_8_CHR';
    case TraceEligibleBondIdentifier = 'ID_TRACE';
    case ItalianIdentifierNumber = 'ID_ITALY';
    case LocalExchangeSecuritySymbol = 'ID_EXCH_SYMBOL';
    case FullExchangeSymbol = 'ID_FULL_EXCHANGE_SYMBOL';
    case CompositeFinancialInstrumentGlobalIdentifier = 'COMPOSITE_ID_BB_GLOBAL';
    case ShareClassFinancialInstrumentGlobalIdentifier = 'ID_BB_GLOBAL_SHARE_CLASS_LEVEL';
    case FinancialInstrumentGlobalIdentifier = 'ID_BB_GLOBAL';
    case SecurityIdNumberDescription = 'ID_BB_SEC_NUM_DES';
    case Ticker = 'TICKER';
    case BaseTicker = 'BASE_TICKER';
    case Cusip8Character = 'ID_CUSIP_8_CHR';
    case OccSymbol = 'OCC_SYMBOL';
    case UniqueIdentifierForFutureOption = 'UNIQUE_ID_FUT_OPT';
    case OpraSymbol = 'OPRA_SYMBOL';
    case TradingSystemIdentifier = 'TRADING_SYSTEM_IDENTIFIER';
    case ShortCode = 'ID_SHORT_CODE';
    case VendorIndexCode = 'VENDOR_INDEX_CODE';
}
