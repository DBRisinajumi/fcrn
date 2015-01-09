fcrn
====

Yii currency module


SysCompany Base currency
=======================
Define base currencies for SysCompanies depend YEAR and source, where get currency
Define in table fcbc_ccmp_base_currency:
 - fcbc_ccmp_id - sys company ccmp_id
 - fcbc_year_from -  start year
 - fcbc_year_to - end year or null, if actual record
 - fcbc_fcsr_id - currency sources. Currently implemented 1- bank.lv EUR, 2 - bl.lt LTL
 - fcbc_fcrn_id - currency id from table fcrn_currency