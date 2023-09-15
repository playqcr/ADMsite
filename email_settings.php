<?php
/****************************************************
****   New Email Project                          ***
****   Designed by: Tom Moore                     ***
****   Written by: Tom Moore                      ***
****   (c) 2022 TEEMOR eBusiness Solutions        ***
****************************************************/

// ==> GENERAL

// --> General settings
$email_settings['site_title']='QP IT Help Desk';
$email_settings['site_url']='http://qcr-net.qcr.local/helpdesk';
$email_settings['hesk_title']='QP IT Help Desk';
$email_settings['hesk_url']='http://qcr-net.qcr.local/helpdesk';
$email_settings['webmaster_mail']='webmaster@playqcr.com';
$email_settings['noreply_mail']='support@playqcr.com';
$email_settings['noreply_name']='QP IT Help Desk';
$email_settings['site_theme']='hesk3';
$email_settings['admin_css']=0;
$email_settings['admin_css_url']='https://www.example.com/hesk-style.css';

// --> Language settings
$email_settings['can_sel_lang']=0;
$email_settings['language']='English';
$email_settings['languages']=array(
'English' => array('folder'=>'en','hr'=>'------ Reply above this line ------'),
);

// --> Database settings
/*$email_settings['db_host']='localhost';
$email_settings['db_name']='helpdsk';
$email_settings['db_user']='helpdesk';
$email_settings['db_pass']='H3lPd35kU53r!';
$email_settings['db_pfix']='hd_';
$email_settings['db_vrsn']=1;*/

/*
// ==> HELP DESK

// --> Help desk settings
$email_settings['admin_dir']='admin';
$email_settings['attach_dir']='attachments';
$email_settings['cache_dir']='cache';
$email_settings['max_listings']=20;
$email_settings['print_font_size']=12;
$email_settings['autoclose']=0;
$email_settings['max_open']=0;
$email_settings['due_soon']=7;
$email_settings['new_top']=1;
$email_settings['reply_top']=0;
$email_settings['hide_replies']=0;
$email_settings['limit_width']=800;

// --> Features
$email_settings['autologin']=1;
$email_settings['autoassign']=0;
$email_settings['require_email']=1;
$email_settings['require_owner']=1;
$email_settings['require_subject']=1;
$email_settings['require_message']=1;
$email_settings['custclose']=1;
$email_settings['custopen']=0;
$email_settings['rating']=1;
$email_settings['cust_urgency']=0;
$email_settings['sequential']=1;
$email_settings['time_worked']=1;
$email_settings['spam_notice']=1;
$email_settings['list_users']=0;
$email_settings['debug_mode']=0;
$email_settings['short_link']=0;
$email_settings['select_cat']=1;
$email_settings['select_pri']=0;
$email_settings['cat_show_select']=15;
$email_settings['staff_ticket_formatting']=2;

// --> SPAM Prevention
$email_settings['secimg_use']=0;
$email_settings['secimg_sum']='88EA99TZWB';
$email_settings['recaptcha_use']=0;
$email_settings['recaptcha_public_key']='';
$email_settings['recaptcha_private_key']='';
$email_settings['question_use']=0;
$email_settings['question_ask']='What color is snow? (give a 1 word answer to show you are a human)';
$email_settings['question_ans']='white';

// --> Security
$email_settings['attempt_limit']=6;
$email_settings['attempt_banmin']=10;
$email_settings['flood']=3;
$email_settings['reset_pass']=1;
$email_settings['email_view_ticket']=1;
$email_settings['x_frame_opt']=1;
$email_settings['samesite']='Lax';
$email_settings['force_ssl']=0;
$email_settings['url_key']='ah8R45-Pdj.7rXJHu6bc79';

// --> Attachments
$email_settings['attachments']=array (
'use' => 1,
'max_number' => 4,
'max_size' => 2097152,
'allowed_types' => array('.gif','.jpg','.png','.zip','.rar','.csv','.doc','.docx','.xls','.xlsx','.txt','.pdf')
);


// ==> KNOWLEDGEBASE

// --> Knowledgebase settings
$email_settings['kb_enable']=1;
$email_settings['kb_wysiwyg']=1;
$email_settings['kb_search']=2;
$email_settings['kb_search_limit']=10;
$email_settings['kb_views']=1;
$email_settings['kb_date']=0;
$email_settings['kb_recommendanswers']=1;
$email_settings['kb_rating']=1;
$email_settings['kb_substrart']=200;
$email_settings['kb_cols']=2;
$email_settings['kb_numshow']=3;
$email_settings['kb_popart']=6;
$email_settings['kb_latest']=6;
$email_settings['kb_index_popart']=6;
$email_settings['kb_index_latest']=6;
$email_settings['kb_related']=5;

*/
// ==> EMAIL

// --> Email sending
$email_settings['smtp']=1;
$email_settings['smtp_host_name']='10.221.0.5';
$email_settings['smtp_host_port']=25;
$email_settings['smtp_timeout']=20;
$email_settings['smtp_ssl']=0;
$email_settings['smtp_tls']=0;
$email_settings['smtp_user']='';
$email_settings['smtp_password']='';

// --> Email piping
$email_settings['email_piping']=0;

// --> POP3 Fetching
$email_settings['pop3']=0;
$email_settings['pop3_job_wait']=15;
$email_settings['pop3_host_name']='mail.playqcr.com';
$email_settings['pop3_host_port']=587;
$email_settings['pop3_tls']=0;
$email_settings['pop3_keep']=1;
$email_settings['pop3_user']='support@playqcr.com';
$email_settings['pop3_password']='TWD&lt;@dm1n!&gt;';

// --> IMAP Fetching
$email_settings['imap']=0;
$email_settings['imap_job_wait']=15;
$email_settings['imap_host_name']='mail.example.com';
$email_settings['imap_host_port']=993;
$email_settings['imap_enc']='ssl';
$email_settings['imap_noval_cert']=0;
$email_settings['imap_keep']=0;
$email_settings['imap_user']='';
$email_settings['imap_password']='';

// --> Email loops
$email_settings['loop_hits']=5;
$email_settings['loop_time']=300;

// --> Detect email typos
$email_settings['detect_typos']=0;
$email_settings['email_providers']=array('aim.com','aol.co.uk','aol.com','att.net','bellsouth.net','blueyonder.co.uk','bt.com','btinternet.com','btopenworld.com','charter.net','comcast.net','cox.net','earthlink.net','email.com','facebook.com','fastmail.fm','free.fr','freeserve.co.uk','gmail.com','gmx.at','gmx.ch','gmx.com','gmx.de','gmx.fr','gmx.net','gmx.us','googlemail.com','hotmail.be','hotmail.co.uk','hotmail.com','hotmail.com.ar','hotmail.com.mx','hotmail.de','hotmail.es','hotmail.fr','hushmail.com','icloud.com','inbox.com','laposte.net','lavabit.com','list.ru','live.be','live.co.uk','live.com','live.com.ar','live.com.mx','live.de','live.fr','love.com','lycos.com','mac.com','mail.com','mail.ru','me.com','msn.com','nate.com','naver.com','neuf.fr','ntlworld.com','o2.co.uk','online.de','orange.fr','orange.net','outlook.com','pobox.com','prodigy.net.mx','qq.com','rambler.ru','rocketmail.com','safe-mail.net','sbcglobal.net','t-online.de','talktalk.co.uk','tiscali.co.uk','verizon.net','virgin.net','virginmedia.com','wanadoo.co.uk','wanadoo.fr','yahoo.co.id','yahoo.co.in','yahoo.co.jp','yahoo.co.kr','yahoo.co.uk','yahoo.com','yahoo.com.ar','yahoo.com.mx','yahoo.com.ph','yahoo.com.sg','yahoo.de','yahoo.fr','yandex.com','yandex.ru','ymail.com');

// --> Notify customer when
$email_settings['notify_new']=1;
$email_settings['notify_skip_spam']=1;
$email_settings['notify_spam_tags']=array('Spam?}','***SPAM***','[SPAM]','SPAM-LOW:','SPAM-MED:');
$email_settings['notify_closed']=1;

// --> Other
$email_settings['strip_quoted']=1;
$email_settings['eml_req_msg']=0;
$email_settings['save_embedded']=1;
$email_settings['multi_eml']=1;
$email_settings['confirm_email']=0;
$email_settings['open_only']=1;


// ==> TICKET LIST

//$email_settings['ticket_list']=array('trackid','lastchange','category','name','email','subject','status','owner','lastreplier');

// --> Other
$email_settings['submittedformat']=2;
$email_settings['updatedformat']=2;


// ==> MISC

// --> Date & Time
$email_settings['timezone']='America/Phoenix';
$email_settings['timeformat']='Y-m-d H:i:s';
$email_settings['time_display']='0';

// --> Other
$email_settings['ip_whois']='https://whois.domaintools.com/{IP}';
$email_settings['maintenance_mode']=0;
$email_settings['alink']=1;
$email_settings['submit_notice']=0;
$email_settings['online']=0;
$email_settings['online_min']=10;
$email_settings['check_updates']=0;