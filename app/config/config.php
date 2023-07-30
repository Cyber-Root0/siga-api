<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

define("BASE", '/');
define('UNSET_URI_COUNT',0);
define('DEBUG_URI',false);

//HTTP REQUEST
define("SIGA_REQUEST_LOGIN",'{
    "_EventName": "E\'EVT_CONFIRMAR\'.",
    "_EventGridId": "",
    "_EventRowId": "",
    "MPW0005_CMPPGM": "login_top.aspx",
    "MPW0005GX_FocusControl": "",
    "vSAIDA": "",
    "vREC_SIS_USUARIOID": "",
    "GX_FocusControl": "vSIS_USUARIOID",
    "GX_AJAX_KEY": "8E52B5B99D70A87D9EE89570291ACC86",
    "AJAX_SECURITY_TOKEN": "A8B9DECE0E27179FF4F5F08F98769E720CB87ABB4460CC4A68C467A81BF554BB",
    "GX_CMP_OBJS": {
      "MPW0005": "login_top"
    },
    "sCallerURL": "",
    "GX_RES_PROVIDER": "GXResourceProvider.aspx",
    "GX_THEME": "GeneXusX",
    "_MODE": "",
    "Mode": "",
    "IsModified": "1"
  }'
);

define("DOMAIN_SIGA", "siga.cps.sp.gov.br");
define("PAGE_ALL_HISTORY", "https://siga.cps.sp.gov.br/aluno/historicocompleto.aspx");
define("PAGE_LOGIN","https://siga.cps.sp.gov.br/aluno/login.aspx");

