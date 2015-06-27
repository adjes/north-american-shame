<?php 

namespace App;

class Config
{
	public static $dbs = array(

		"MySql" => array(
			"driver" => "mysql",
			"host" => "localhost",
			"database" => "imgsz",
			"user" => "imgsz",
			"pass" => "qwerty"
			)

		);

	public static $db_class_routing = array(


		);

	public static $forms = array (
		
		"name" => "name",
		"password" => "password",

		"subject_name" => "subject_name",

		"article_title" => "article_title",
		"article_content" => "article_content",
		"article_subject_id" => "article_subject_id",
		"article_user_id" => "article_user_id",

		"comment_content" => "comment_content",
		"comment_user_id" => "comment_user_id",
		"comment_article_id" => "comment_article_id",

		"site_title" => "site_title",
		"site_meta" => "site_meta",

		);

}