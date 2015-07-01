var core = function (core) {
   	
// route: events -> util -> ajax -> util -> dom (-> u -> dom);


// todo:
// add cyrillic script regex to htaccess for url recognition;
// error notifications;
// css tweaks;

	var config = {
		dataSource : "http://imgsz/",
	};

	var cache = {};

	var nav = {
		path : function () {
			return window.location.pathname;
		},
		switchTo: function (path) {
			switch (path) {
				case "/admin/manage-subjects":
					if (cache.data.session.user_admin == "1" ) {
						document.title = u.getTitle() + " | Admin | Manage subjects";
						d.generateManageSubjects();
						d.generateArtSelectables();
						d.generateRelatedPreview();
						d.manageSectionSetActive("a#manage-subjects");
						break;
					} else nav.switchTo("/"); 
					window.history.replaceState("", "", "/");
					break;

				case "/admin/manage-articles":
					if (cache.data.session.user_admin == "1" ) {
						document.title = u.getTitle() + " | Admin | Manage articles";
						d.generateManageArticles();
						d.generateArtSelectables();
						d.generateRelatedPreview();
						d.manageSectionSetActive("a#manage-articles");
						break;
					} else nav.switchTo("/"); 
					window.history.replaceState("", "", "/");
					break;
				case "/admin/manage-users":
					if (cache.data.session.user_admin == "1" ) {
						document.title = u.getTitle() + " | Admin | Manage users";
						d.generateManageUsers();
						d.generateArtSelectables();
						d.generateRelatedPreview();
						d.manageSectionSetActive("a#manage-users");
						break;
					} else nav.switchTo("/"); 
					window.history.replaceState("", "", "/");
					break;
				case "" :
				case "/" :
					document.title = u.getTitle() + " | Home";
					d.generateMain();
					d.subjectSetActive("span.icon-home");
					break;
				default :

					if (path.indexOf("/") != -1) {
		        		pathArray = path.split("/");
		        	}

		        	console.log(pathArray);

					var subject = u.getSbjByName(pathArray[1]);
					var article = u.getArtByName(pathArray[2]);

					if (article) {
						d.articleSetActive(article, subject);
						d.generateArticleUnit(article.id);
						u.setArticleTitle(article, subject);
						d.generateArtSelectables();
						d.generateRelatedPreview();
						return;
					}
					if (subject) {
						d.subjectSetActive(subject);
						d.generateSbjArticles(subject.id);
						u.setSubjectTitle(subject);
						d.generateArtSelectables();
						d.generateRelatedPreview();
						return;
					} 
					document.title = u.getTitle() + " | Home";
					d.generateMain();
					window.location.pathname = "/";
					d.subjectSetActive("span.icon-home");
					console.log("default location switch");
				
			}
		},
		popState: function () {
			window.onpopstate = function(event) {
				if (document.location.hash) return;
				nav.switchTo(nav.path());
			};
		}(),
};

	var tmpl = {
		spinner: function () {
			return '<span class="icon-span icon-spinner">&#xe982;</span>';
		},
		menuItem: function (el) {
			return "<li class='subject-unit' data-sbj-id='" + el.id + "'><a class='menu-item' href=''>" + el.name + "</a></li>";
		},
		menuHomeIcon: function () {
			return '<span class="icon-span icon-home">&#xe900;</span>';
		},
		articlePreview: function (el) {
			var ctrl = "";
			if (cache.data.session.user_admin == "1") {
						ctrl = '<div class="admin-art-ctrl">' +
						'<a href="#article-edit" class="article-edit-btn-p">Edit article</a>' +
						'</div>';
			}
			return '<div class="row content-block article-unit article-preview" data-art-id="' + el.id + '">' +
						'<h2><a href="" class="article-title">' + el.title + '</a></h2>' +
						ctrl +
						'<p class="art-title-desc"> by <span class="user-unit" data-user-id="' + el.user_id + '"><a class="art-desc-user" href="#user-profile" >' + el.user_name + '</span></a></p>' +
				    	'<p class="art-text">' + u.getFirstParagraph(el.content) + '</p>' +
				    	'<div class= "comments-link">' +
					    	'<a href="">Comments (' + el.comments.length + ')</a>' +
				    	'</div>' +
	    			'</div>';
			},
		relatedPreview: {
			sbjLayout: function (el) {
				return '<div class="related-block subject-unit" data-sbj-id="' + el.id + '">' +
						'<H3>Last ' + el.name + ' articles</H3>' +
						'<ul>' +
						'</ul>' +
					'</div>	';
				},
			artLayout: function (el) {
				return '<li class="article-unit" data-art-id="' + el.id + '"><a class="article-title" data-art-id="' + el.id + '" href="">' + el.title + '</a></li>';
			}
		},
		loggedIn: function (el) {
			return '<span class="user-unit" data-user-id="' + el.user_id + '">Logged in as: <a class="user-title-head" href="#user-profile">' + el.user_name + '</a> </span>';
		},
		userMenu: function () {
			var ctrl = "";
			if (cache.data.session.user_admin == "1") {
						ctrl = '<li><a id="show-settings" href="#settings">Settings</a></li>' +
		        	'<li><a id="manage-users" href="">Manage users</a></li>' +
		        	'<li><a id="manage-articles" href="">Manage articles</a></li>' +
		        	'<li><a id="manage-subjects" href="">Manage subjects</a></li>';
			}
			return  '<li><a id="logoutBtn" href="">Log out</a></li>' + ctrl;
		        	
		},
		manageArticles: {
			outLayout: function () {
				return '<div class="row content-block manage-articles-block">' +
							'<h2 class="admin-area-title">Manage articles</h2>' +
							'<div class="item-add-new">' +
								'<a href="#article-new">Add new article</a>' +
							'</div>' +
							'<div id="art-subject-container">' +
							'</div>' +
							'<div id="art-empty-container" class="art-uncategorized">' +
								'<ul>' +
								
			    				'</ul>' +
							'</div>' +
		    			'</div>';
			},
			sbjLayout: function (el) {
				return '<h3 class="sbj-list-title inner-row">' + el.name + '</h3>' +
					'<div class="manage-articles" data-sbj-id="' + el.id + '">' +
		    			'<ul>' +
		    			'<li data-sbj-id="' + el.id + '" class="row inner-row article-unit sbjLayout-placeholder">' +
			   				'<div class="column-s-12"> </div>' +
		    			'</li>' +
		    			'</ul>' +
	    			'</div>';
			},
			artLayout: function (el) {
				return '<li class="row inner-row article-unit" data-art-id="' + el.id + '">' +
		    					'<div class="column-s-1 column-m-1">id: ' + el.id + '</div>' +
								'<div class="column-s-7 column-m-7">' +
									'<a href="" class="article-title">' + el.title + '</a>' +
								'</div>' +
								'<a href="#article-edit" class="column-s-2 column-m-2 article-edit-btn-ma">Edit</a>' +
								'<a href="#" class="column-s-2 column-m-2 article-delete-btn">Delete</a>' +
		    			'</li>';
			},
			empty: function (el) {
				return '<li data-sbj-id="' + el.id + '" class="row inner-row article-unit sbjLayout-placeholder">' +
		   					'<div class="column-s-12"> </div>' +
		    			'</li>';
			},
			selectables: function (el) {
				return '<option value="' + el.id + '">' + el.name + '</option>';
			}
		},
		article: {
			articleUnit: function (el) {
				var ctrl = "";
				var updatedString = "";
				if (cache.data.session.user_admin == "1") {
						ctrl = '<div class="admin-art-ctrl">' +
						'<a href="#article-edit" class="article-edit-btn-au">Edit article</a>' +
						'</div>';
				}
				if (el.updated_at) {
					updatedString = "; updated at " + el.updated_at;
				}
				return '<div class="row content-block article-unit" data-art-id="' + el.id + '">' +
						'<h2>' + el.title + '</h2>' +
						ctrl +
						'<p class="art-title-desc">by <span class="user-unit" data-user-id="' + el.user_id + '"><a class="art-desc-user" href="#user-profile">' + el.user_name + '</a></span>, ' + el.created_at + updatedString + '</p>' +
				    	'<p class="art-text">' +
				    	u.replaceSpaces(el.content) + 
				    	'</p>' +
				    	'<div class="row comments-block">' +
				    		
				    	'</div>' +
		    		'</div>';
			},
			commentUnit: function (el) {
				var ctrl = "";
				if (cache.data.session.user_admin == "1") {
						ctrl = '<div class="comment-ctrl">' +
						'<a href="" class="comment-delete-btn">Delete comment</a>' +
						'</div>';
				}
				return '<div class="comment-unit" data-cmnt-id="' + el.id + '">' +
				    		'<div class="comment-body">' +
				    			'<div class="comment-header">' +
				    				'<span class="user-unit" data-user-id="' + el.user_id + '"><a class="cmnt-desc-user" href="#user-profile">' + el.name + '</a></span><span> at ' + el.created_at + '</span>' +
			    					ctrl +
				    			'</div>' +
				    			'<div class="comment-text">' +
				    				'<p>' + el.content + '</p>' +
				    			'</div>' +
				    		'</div>' +
			    		'</div>';
			},
			postComment: function (el) {
				var tmpl = "";
				if (cache.data.session.user_id) {
					tmpl = '<div class="row content-block comment-post" data-art-id="' + el.id + '">' +
	    			'<label class="cmnt-post-header">Leave a comment:</label>' +
	    			'<textarea class="cmnt-post-body input-area"></textarea>' +
	    			'<div class="row">' +
	    				'<a href="" class="btn comment-post-btn"> Post comment</a>' +
	    			'</div>' +
	    		'</div>';
				}
				return tmpl;
			}
		},
		manageSubjects: {
			outLayout: function () {
				return '<div class="row content-block">' +
					'<h2 class="admin-area-title">Manage subjects</h2>' +
					'<div class="item-add-new">' +
						'<a href="#subject-new">Add new subject</a>' +
					'</div>' +
				    '<div class="manage-subjects">' +
		    			'<ul>' +
		    			'</ul>' +
		    		'</div>';
			},
			sbjLayout: function (el) {
				return '<li class="row inner-row subject-unit" data-sbj-id="' + el.id + '">' +
	    					'<div class="column-s-1 column-m-1">id: ' + el.id + '</div>' +
							'<div class="column-s-5 column-m-5">' +
								'<input class="input-area subject-name" type="text" value="' + el.name + '">' +
							'</div>' +
							'<a href="" class="column-s-3 column-m-3 sbj-rename-btn">Rename</a>' +
							'<a href="" class="column-s-3 column-m-3 sbj-delete-btn">Delete</a>' +
	    				'</li>';
			}
		},
		manageUsers: {
			outLayout: function () {
				return '<div class="row content-block">' +
					'<h2 class="admin-area-title">Manage users</h2>' +
					'<div class="item-add-new">' +
						'<a href="#register">Add new user</a>' +
					'</div>' +
				    '<div class="manage-users">' +
		    			'<ul>' +
		    			'</ul>' +
		    		'</div>';
			},
			userLayout: function (el) {
				var isAdmin;
				var deleteString="";
				if (el.admin=="1") {
					isAdmin = "admin";
				} else isAdmin = "user";

				if (cache.data.session.user_id != el.id) {
					deleteString = '<a href="" class="column-s-2 column-m-2 user-delete-btn">Delete</a>';
				}
				return '<li class="row inner-row user-unit" data-user-id="' + el.id + '">' +
		    					'<div class="column-s-1 column-m-1">id: ' + el.id + '</div>' +
								'<div class="column-s-7 column-m-7">' +
									'<a href="#user-profile" class="user-title">' + el.name + '</a></div>' +
								'<div class="column-s-2 column-m-2">' + isAdmin + '</a>' +
								'</div>' +
								deleteString +
		    			'</li>';
			}
		}
	};

	var ajax = {
		pool : [],
		setup : function () {

			$(document).ajaxSend(function(e, xhr) {
			  ajax.pool.push(xhr);
			});

			$(document).ajaxComplete(function(e, xhr) {
			    ajax.pool = ajax.pool.filter(function (el){
			    	return el != xhr;
			    });
			    d.hideSpinner();
		  	});

		  	$(document).ajaxStart(function(e) {
		  		d.showSpinner();
		  	});
		}(),
		checkAbort: function () {

			if(ajax.pool.length) {
				ajax.pool.forEach(function(el){
					el.abort();
				});
			}
		},
		getData : function () {
			ajax.checkAbort();
			return $.get(config.dataSource, 
				function (res) {
					cache.data = res;
					return this;
				}, "json");
		},
		getLogout : function () {
			ajax.checkAbort();
			return $.get(config.dataSource + "users/logout", 
				function (res) {
					cache.logoutRes = res;
					return this;
				}, "json");
		},
		postLogin : function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "users/login", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postArtAdd : function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "articles/add", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postArtEdit : function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "articles/edit", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postArtDelete : function (dataId) {
			ajax.checkAbort();
			return $.post(config.dataSource + "articles/delete", 
				dataId, 
				function(res) {
					return this;
				}, "json");
		},
		postComment : function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "comments/add", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postCmntDelete : function (dataId) {
			ajax.checkAbort();
			return $.post(config.dataSource + "comments/delete", 
				dataId, 
				function(res) {
					return this;
				}, "json");
		},
		postSbjDelete : function (dataId) {
			ajax.checkAbort();
			return $.post(config.dataSource + "subjects/delete", 
				dataId, 
				function(res) {
					return this;
				}, "json");
		},
		postSbjAdd: function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "subjects/add", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postSbjEdit: function(data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "subjects/edit", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postUserDelete: function(data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "users/delete", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postUserAdd: function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "users/add", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		postUserEdit: function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "users/set_admin", 
				data, 
				function(res) {
					return this;
				}, "json");
		},
		getDummy: function () {
			ajax.checkAbort();
			return $.get(config.dataSource + "dummies/get_dummy",
				function (res) {
					return this;
				}, "json");
		},
		postTitle: function (data) {
			ajax.checkAbort();
			return $.post(config.dataSource + "desc/set_title", 
				data, 
				function(res) {
					return this;
				}, "json");
		}
	};

	var u = {
		sortSubjects: function () {
			cache.data.subjects.sort(function(a,b) {
				return a.id - b.id;
			});
		},
		sortArticles: function () {
			cache.data.articles.sort(function(a,b) {
				return b.id - a.id;
			});
		},
		getFirstParagraph: function (el) {
			if (el.indexOf("\n") != -1) {
		      el = el.split("\n").shift();
        	}
        	return el;
		},
		replaceSpaces: function (el) {
			el = el.replace(/\n/g, "<br>");
			return el;
		},
		getLoginVal : function () {
			return {"name" : $("input#login-user").val().trim(),
					"password" : $("input#login-pass").val().trim()
					};
		},
		getNewUserVal: function () {
			return {"name" : $("input#user-input-name").val().trim(),
					"password" : $("input#user-input-name").val().trim()
					};
		},
		getArtEditVal : function (opt) {
			return (cache.data.session.user_id) ?
			{"article_title" : $("input#art-" + opt + "-title").val().trim(),
			 "article_content"  : $("textarea#art-" + opt + "-content").val().trim(),
			 "article_subject_id" : $("select#art-" + opt + "-subject_id").val(),
			 "article_user_id" : cache.data.session.user_id
			} : false;
		},
		getArtId : function (el) {
			return {"article_id" : $(el).parents(".article-unit, .content-block").data("art-id")};
		},
		getArtById: function (id) {
			var article = cache.data.articles.filter(function(el){
				return el.id == id;
			})[0];
			return article;
		},
		getArtByName: function (title) {
			if (title) {
				title = title.replace(/\_+/g, " ");
				var article = cache.data.articles.filter(function(el){
					return el.title.toLowerCase() == title;
				})[0];
				return article;	
			}
		},
		getCmntId: function (el) {
			return {"comment_id" : $(el).parents(".comment-unit").data("cmnt-id")};
		},
		getCmntVal : function (id) {
			return {'comment_content' : $("textarea.cmnt-post-body").val().trim(),
				'comment_user_id' : cache.data.session.user_id
			};
		},
		getSbjId: function (el) {
			return {"subject_id" : $(el).parents(".subject-unit").data("sbj-id")};
		},
		getSbjNewVal: function () {
			return {"subject_name" : $("input#subject-newname").val().trim()};
		},
		getSbjVal: function (id) {
			return {'subject_name' : $("li.subject-unit[data-sbj-id='" + id + "'] .subject-name").val().trim()
			};
		},
		getSbjById: function (id) {
			var subject = cache.data.subjects.filter(function(el){
				return el.id == id;
			})[0];
			return subject;
		},
		getSbjByName: function (name) {

			var subject = cache.data.subjects.filter(function(el){
				return el.name.toLowerCase() == name;
			})[0];
			return subject;
		},
		getUserId: function(el) {
			return {"user_id" : $(el).parents(".user-unit").data("user-id")};
		},
		getUserEditVal: function () {
			return {"user_admin" : $("select#user-profile-admin").val()};
		},
		getTitle: function () {
			if (!cache.site_title) {
				cache.site_title = $("title").first().text();
				return cache.site_title;
			} else return cache.site_title;
		},
		getTitleEditVal: function () {
			return {"site_title" : $("input#title-name").val().trim()};
		},
		deleteSubject: function (id) {
			cache.data.subjects.forEach(function (el, index, arr) {
				if (el.id == id) {
					arr.splice(index, 1);
				}
			});
			cache.data.articles.forEach(function (el) {
				if (el.subject_id == id) el.subject_id =null;
			});
			d.generateArtSelectables();
			$("[data-sbj-id='" + id + "']").remove();
		},
		deleteArticle: function (id) {
			var subjectId;
			cache.data.articles.forEach(function (el, index, arr) {
				if (el.id == id) {
					subjectId = el.subject_id;
					arr.splice(index, 1);
				}
			});
			$("[data-art-id='" + id + "']").remove();
			u.checkLastArtList(subjectId);
			d.generateRelatedPreview();
		},
		checkLastArtList : function (subjectId) {

			var subject = u.getSbjById(subjectId);
			if (subject) {
				if ($("div.manage-articles[data-sbj-id='" + subject.id + "'] ul").is(":empty")) {
					$("div.manage-articles[data-sbj-id='" + subject.id + "'] ul").append(tmpl.manageArticles.empty(subject.id));
				}
			}
		},
		deleteComment: function (article, comment) {
			console.log(article,comment);
			cache.data.articles.forEach(function(el){
				if (article.article_id==el.id) {
					el.comments.forEach(function(el, index, arr){
						if (comment.id == el.id) {
							arr.splice(index, 1);
						}
					});
				}
			});
			d.deleteComment(comment.id);
		},
		deleteUser: function (id){
			cache.data.users.forEach(function (el, index, arr) {
				if (el.id == id) {
					arr.splice(index, 1);
				}
				d.deleteUser(id);
			});
		},
		addSubjects : function (data) {
			cache.data.subjects.push(data);
			u.updateSubjects();
		},
		updateSubjects : function () {
			$("nav.menu ul").empty();
			d.generateMenu();
			d.generateManageSubjects();
			d.generateArtSelectables();
			d.generateRelatedPreview();

		},
		editSubjects : function (data) {
			cache.data.subjects.forEach(function (el){
				if(data.id == el.id) {
					el.name = data.name;
					u.updateSubjects();
					return;
				}
			});

		},
		editArticles : function (data) {
			cache.data.articles.forEach(function (el){
				
				if(data.id == el.id) {
					el.title = data.title;
					el.content = data.content;
					el.subject_id = data.subject_id;
					el.user_id = data.user_id;
					if ($("div.article-unit[data-art-id='" + el.id + "']:not('.article-preview')").length) {
						d.generateArticleUnit(el.id);
					}
					$("div.article-preview[data-art-id='" + el.id + "']").replaceWith(tmpl.articlePreview(el));
					if ($("div.manage-articles-block").length) {
						d.generateManageArticles();
					}
					d.generateRelatedPreview();
					return;
				}
			});
		},
		editUsers: function (data) {
			cache.data.users.forEach (function (el,index,arr) {
				if (data.id == el.id) {
					arr[index].admin = data.admin;
					return;
				}
			});
			d.generateManageUsers();
		},
		addArticles: function (data) {
			cache.data.articles.unshift(data);
			d.generateManageArticles();
			d.generateRelatedPreview();
		},
		updateManageUsers: function (user) {
			if (cache.data.session.user_admin=="1") {
				cache.data.users.push(user);
				d.generateManageUsers();
			}
		},
		setSubjectTitle : function (subj) {
			document.title = u.getTitle() + " | " + subj.name;
		},
		setArticleTitle: function (article, subject) {
			document.title = u.getTitle() + " | " + subject.name + " | " + article.title;
		}
	};

	var d = {
		generateMenu : function  () {
			$("nav.menu ul").append(tmpl.menuHomeIcon());

			cache.data.subjects.forEach(function (el) {
				$("nav.menu ul").append(tmpl.menuItem(el));
			});
		},
		checkLogin : function () {
			if (cache.data.session.user_name) {
				$("div.login-block").empty().append(tmpl.loggedIn(cache.data.session));
					$("div.admin-menu ul").append(tmpl.userMenu());
				if (cache.data.session.user_admin != "1") {
					$("div#article-new, div#article-edit, div#subject-new, div#settings, div#register, div#login").remove();			
				}
			} 
			else {
				$("div#article-new, div#article-edit, div#subject-new, div#settings").remove();
			}
		},
		generateArtPreview : function () {
			cache.data.articles.forEach(function (el) {
				if (el.subject_id) {
					$("div.content-left").append(tmpl.articlePreview(el));
				}
			});
		},
		generateManageArticles : function () {

			$("div.content-left").empty().append(tmpl.manageArticles.outLayout());

			if (cache.data.subjects.length) {
				cache.data.subjects.forEach(function (subject) {
					$("div#art-subject-container").append(tmpl.manageArticles.sbjLayout(subject));
					cache.data.articles.forEach(function(article) {
						if (subject.id == article.subject_id) {
							$("li.sbjLayout-placeholder[data-sbj-id='" + subject.id + "']").remove();
							$("div.manage-articles[data-sbj-id='" + subject.id + "'] ul").append(tmpl.manageArticles.artLayout(article));
						}
					});

				u.checkLastArtList(subject.id);
				});
				cache.data.articles.forEach(function(article) {
					if (article.subject_id === null) {
						$("div#art-empty-container ul").append(tmpl.manageArticles.artLayout(article));
					}
				});
			} else if (cache.data.articles.length) {
				cache.data.articles.forEach(function(article) {
					$("div#art-empty-container ul").append(tmpl.manageArticles.artLayout(article));
				});
			}
		},
		generateArtSelectables : function () {
			$("select#art-add-subject_id").empty();
			$("select#art-edit-subject_id").empty();
			cache.data.subjects.forEach ( function (subject) {
				$("select#art-add-subject_id").append(tmpl.manageArticles.selectables(subject));
				$("select#art-edit-subject_id").append(tmpl.manageArticles.selectables(subject));
			});
		},
		generateArtEditData : function (id) {
			var article = cache.data.articles.filter(function(el){
				return el.id == id;
			})[0];
			if (article) {
				$("input#art-edit-title").val(article.title);
				$("textarea#art-edit-content").val(article.content);
				$("select#art-edit-subject_id").val(article.subject_id);
			}
		},
		deleteMngArticlesListItem : function (id) {
			$(".article-unit[data-art-id='" + id + "']").remove();
		},
		generateArticleUnit : function (id) {
			var article = cache.data.articles.filter(function (el) {
				return el.id == id;
			})[0];


			$("div.content-left").empty().append(tmpl.article.articleUnit(article));

			if (article.comments) article.comments.forEach(function (el) {
				$("div.comments-block").append(tmpl.article.commentUnit(el));
			});

			$("div.content-left").append(tmpl.article.postComment(article));
		},
		deleteComment: function (id) {
			$(".comment-unit[data-cmnt-id='" + id + "']").remove();
		},
		generateManageSubjects: function () {
			$("div.content-left").empty().append(tmpl.manageSubjects.outLayout());

			cache.data.subjects.forEach(function (subject) {
				$("div.manage-subjects ul").append(tmpl.manageSubjects.sbjLayout(subject));
			});
		},
		generateSbjArticles: function(id) {

			$("div.content-left").empty();
			cache.data.articles.forEach(function(el){
				if (el.subject_id==id) {
					$("div.content-left").append(tmpl.articlePreview(el));
				}
			});
		},
		generateRelatedPreview : function () {
			$("div.content-right").empty();
			cache.data.subjects.forEach(function(subject){
				var articles = cache.data.articles.filter(function(article){
					return article.subject_id == subject.id;
				});
				if (articles.length) {
					$("div.content-right").append(tmpl.relatedPreview.sbjLayout(subject));
						for (var i = 0; i < 3 && articles[i]; i++) {
							$("div.related-block[data-sbj-id='" + subject.id + "'] ul").append(tmpl.relatedPreview.artLayout(articles[i]));
						}
					}
			});
		},
		generateMain: function () {
			$("div.content-left, div.content-right").empty();
			d.generateArtPreview();
			d.generateArtSelectables();
			d.generateRelatedPreview();
		},
		generateManageUsers: function () {
			$("div.content-left").empty().append(tmpl.manageUsers.outLayout());
			cache.data.users.forEach(function (user) {
				$("div.manage-users ul").append(tmpl.manageUsers.userLayout(user));
			});
		},

		generateUserData: function (id) {
				var user = cache.data.users.filter (function(el){
					return el.id==id;
				})[0];

			$("span#user-profile-name").text(user.name);
			if (user.id != cache.data.session.user_id && cache.data.session.user_admin=="1") {
				console.log(user);
				$("div.user-profile-admin-section").show();
				$("select#user-profile-admin").val(user.admin);
			} else {
				console.log("no");

				$("div.user-profile-admin-section").hide();
			}

		},

		deleteUser: function (id) {
			$(".user-unit[data-user-id='" + id + "']").remove();
		},
		subjectSetActive: function(subject) {
			if (subject.id) {
				sbjNode = $("li.subject-unit[data-sbj-id='" + subject.id + "'] a");
			} else sbjNode = subject;
			// $(sbjNode).parents("ul").find(".active").removeClass("active");
			$(".active").removeClass("active");
			$("div.content-right li.article-unit").find(".active").removeClass("active");
			$(sbjNode).addClass("active");
		},
		articleSetActive: function (article, subject) {
			artNode = $("li.article-unit[data-art-id='" + article.id + "'] a");
			sbjNode = $("li.subject-unit[data-sbj-id='" + subject.id + "'] a");
			$(".active").removeClass("active");
			$(artNode).addClass("active");
			$(sbjNode).addClass("active");
		},
		manageSectionSetActive: function (el) {
			$(".active").removeClass("active");
			$(el).addClass("active");

		}, 
		hideLoader: function () {
			$("div.loader").hide();
		},
		showLoader: function () {
			$("div.loader").show();
		},
		showSpinner: function () {
			$("div.logo").html(tmpl.spinner());
		},
		hideSpinner: function () {
			$("div.logo").text("LOGO");
		},
		setTitleSettings: function () {
			$("input#title-name").val(u.getTitle());
		}
	};

	var e = {
		login : function () {
			$("a#loginBtn").on("click", function (e) {
				e.preventDefault();
				ajax.postLogin(u.getLoginVal()).then(function(){
					window.history.replaceState("","", window.location.pathname);
					window.location.reload();
				});
			});
		}(),
		logout : function () {
			$("ul").on("click", "a#logoutBtn", function (e) {
				e.preventDefault();
				ajax.getLogout();
				window.location.reload();
			});
		}(),
		userCreate: function () {
			$("a#user-new-btn").on("click", function (e) {
				e.preventDefault();
				var userData;
					console.log("lol");
					userData = u.getNewUserVal();
					if (userData.name !== "" && userData.password !== "") {
						ajax.postUserAdd(userData).then(function(data){
							if (!cache.data.session.user_id) {
								console.log(u.getNewUserVal());
								ajax.postLogin(u.getNewUserVal()).then(function(){
									location.hash = "#";
									window.history.replaceState("","", window.location.pathname);
									window.location.reload();
								});
							} else {
								u.updateManageUsers(data);
								location.hash = "#";
								window.history.replaceState("","", window.location.pathname);
							}
						});
					}
			});
		}(),
		switchToManageArticles : function () {
			$("ul").on("click", "a#manage-articles", function (e) {
				e.preventDefault();
				document.title = u.getTitle() + " | Admin | Manage articles";
				d.generateManageArticles();
				if (nav.path() != "/admin/manage-articles") {
					window.history.pushState({page: "/admin/manage-articles"}, "manage-articles", "/admin/manage-articles");

				}
				d.manageSectionSetActive(this);
			});
		}(),
		articleAdd : function () {
			$("#art-add-save-btn").on("click", function (e) {
				e.preventDefault();
				var values = u.getArtEditVal("add");
				if (values.article_title !== "" && values.article_content !== "") {
					ajax.postArtAdd(values).then(function (data) {
						u.addArticles(data);
					});
					location.hash = "#";
					window.history.replaceState("","", window.location.pathname);
				}
			});
		}(),
		articleEditData : function () {
			$("div.content-left").on("click", "a.article-edit-btn-ma, a.article-edit-btn-p, a.article-edit-btn-au", function (e) {
				cache.editedArticle = u.getArtId(this);
				d.generateArtEditData(cache.editedArticle.article_id);
			});
		}(),
		articleEdit : function () {
			$("#art-edit-save-btn").on("click", function (e) {
				e.preventDefault();
				var values = u.getArtEditVal("edit");
				if (values.article_title !== "" && values.article_content !== "") {
					values.article_updated = "1";
					if (cache.editedArticle) {
						values.article_id = cache.editedArticle.article_id;
						ajax.postArtEdit(values).then(function(data){
							u.editArticles(data);
						});
						cache.editedArticle = null;
					}
					location.hash = "#";
					window.history.replaceState("","", window.location.pathname);
				}
			});
		}(),
		articleDelete: function () {
			$("div.content-left").on("click", "a.article-delete-btn", function (e) {
				e.preventDefault();
				var id = u.getArtId(this); // object for ajax req
				ajax.postArtDelete(id).then(function() {
					u.deleteArticle(id.article_id);
				});

			});
		}(),
		articleShowUnit: function () {
			$("div.content-left, div.content-right").on("click", "a.article-title, div.comments-link a ", function (e) {
				e.preventDefault();
				var id = u.getArtId(this);

				d.generateArticleUnit(id.article_id);

				var article = u.getArtById(id.article_id);

				var subject = u.getSbjById(article.subject_id);

				u.setArticleTitle(article, subject);

				var title = article.title.replace(/\s+/g,"_");


				if (nav.path() != "/" + subject.name.toLowerCase() + "/" + title.toLowerCase()) {
					window.history.pushState({page: "/" + subject.name + "/" + title},title, "/" + subject.name.toLowerCase() + "/" + title.toLowerCase());
				}

				d.articleSetActive(article, subject);

			});
		}(),
		commentPost : function () {
			$("div.content-left").on("click", "a.comment-post-btn", function (e) {
				e.preventDefault();
				var id = u.getArtId(this);
				var values = u.getCmntVal();
				if (values.comment_content !== "") {
					values.comment_article_id = id.article_id;
					ajax.postComment(values).then(function (data) {
						cache.data.articles.forEach(function (el) {
							if (data.article_id==el.id) {
								el.comments.push(data);
								d.generateArticleUnit(el.id);
								return;
							}
						});
					});
				}
			});
		}(),
		commentDelete: function () {
			$("div.content-left").on("click", "a.comment-delete-btn", function (e) {
				e.preventDefault();
				var id = u.getCmntId(this);
				var article=u.getArtId(this);
				ajax.postCmntDelete(id).then(function (data) {
					console.log(data);
					u.deleteComment(article, data);
				});
			});
		}(),
		switchToManageSubjects: function () {
			$("ul").on("click", "a#manage-subjects", function (e) {
				e.preventDefault();
				document.title = u.getTitle() + " | Admin | Manage subjects";
				d.generateManageSubjects();
				if (nav.path() != "/admin/manage-subjects") {
					window.history.pushState({page: "/admin/manage-subjects"}, "manage-subjects", "/admin/manage-subjects");

				}
				d.manageSectionSetActive(this);
			});
		}(),
		subjectDelete: function () {
			$("div.content-left").on("click", "a.sbj-delete-btn", function (e) {
				e.preventDefault();
				var id = u.getSbjId(this); // object for ajax req
				ajax.postSbjDelete(id).then(function() {
					u.deleteSubject(id.subject_id);
				});

			});
		}(),
		subjectAdd : function () {
			$("#sbj-add-save-btn").on("click", function (e) {
				e.preventDefault();
				var values = u.getSbjNewVal(); 
				if (values.subject_name) {
					ajax.postSbjAdd(values).then(function (data) {
						u.addSubjects(data);
					});
					location.hash = "#";
					window.history.replaceState("","", window.location.pathname);
				}
			});
		}(),
		subjectEdit: function () {
			$("div.content-left").on("click", "a.sbj-rename-btn", function (e) {
				e.preventDefault();
				var id = u.getSbjId(this); // object for ajax req
				id.subject_name = u.getSbjVal(id.subject_id).subject_name;
				if (id.subject_name !== "") {
					ajax.postSbjEdit(id).then(function(data) {
						u.editSubjects(data);
					});
				}
			});
		}(),
		subjectShow: function () {
			$("div.menu-block").on("click", "a.menu-item", function (e) {
				e.preventDefault();
				var id = u.getSbjId(this);

				d.generateSbjArticles(id.subject_id);

				var subject = u.getSbjById(id.subject_id);
				u.setSubjectTitle(subject);
				if (nav.path() != "/" + subject.name.toLowerCase()) {
					window.history.pushState({page: "/" + subject.name},subject.name, "/" + subject.name.toLowerCase());
				}
				d.subjectSetActive(subject);
			});
		}(),
		switchToManageUsers: function () {
			$("ul").on("click", "a#manage-users", function (e) {
				e.preventDefault();
				document.title = u.getTitle() + " | Admin | Manage users";
				d.generateManageUsers();
				if (nav.path() != "/admin/manage-users") {
					window.history.pushState({page: "/admin/manage-users"}, "manage-users", "/admin/manage-users");
				}
				d.manageSectionSetActive(this);
			});
		}(),
		userDelete: function () {
			$("div.content-left").on("click", "a.user-delete-btn", function (e) {
				e.preventDefault();
				var id = u.getUserId(this); // object for ajax req
				ajax.postUserDelete(id).then(function() {
					u.deleteUser(id.user_id);
				});

			});
		}(),
		userEditData: function () {
			$("div.content-left, div.login-block").on("click", "a.user-title, a.user-title-head, a.art-desc-user, a.cmnt-desc-user", function (e) {
				var id = u.getUserId(this); // object for ajax req
				console.log(id);
				cache.editedUser = id;
				d.generateUserData(id.user_id);
			});
		}(),
		userEdit : function () {
			$("section.wrapper").on("click", "a#user-profile-save-btn", function (e) {
				e.preventDefault();
				var values = u.getUserEditVal();
				if (cache.editedUser) {
					values.user_id = cache.editedUser.user_id;
					ajax.postUserEdit(values).then(function(data){
						u.editUsers(data);
					});
					cache.editedArticle = null;
				}
				location.hash = "#";
				window.history.replaceState("","", window.location.pathname);
			});
		}(),
		homePage: function () {
			$("div.menu-block").on("click", "span.icon-home", function (e) {
				document.title = u.getTitle() + " | Home";
				d.generateMain();
				window.history.pushState({page: "index"},"index", "/");
				// window.location.reload();
				d.subjectSetActive(this);
			});
		}(),
		hideHash: function () {
			$("a.modal-close").on("click", function(e){
				e.preventDefault();
				location.hash = "#";
				window.history.replaceState("","", window.location.pathname);
			});
		}(),
		showSettings: function () {
			$("section.wrapper").on("click", "a#show-settings", function (e) {
				d.setTitleSettings();
			});
		}(),
		wipeDataGetDummy: function () {
			$("section.wrapper").on("click", "a#wipe-get-dummy", function (e) {
				// e.preventDefault();
				ajax.getDummy().then(function () {
					window.history.pushState({page: "index"},"index", "/");
					window.location.reload(true);
				});
			});
		}(),
		titleEdit: function () {
			$("section.wrapper").on("click", "a#title-edit", function (e) {
				// e.preventDefault();
				var values = u.getTitleEditVal();
				if (values.site_title !== "") {
					ajax.postTitle(values).then(function () {
						window.history.pushState({page: "index"},"index", "/");
						window.location.reload(true);
					});
				}
			});
		}()

	};

	

	function init () {


		ajax.getData().then(function () {

			u.sortSubjects();
			u.sortArticles();
			d.checkLogin();
			d.generateMenu();
			nav.switchTo(nav.path());
			d.hideLoader();
		});



	}

	$(document).ready(function () {
		init();
	});

   	return {
   		// u : u,
   		// d : d,
   		// config : config,
   		// cache : cache,
   		// init : init,
   		// ajax : ajax,
   		// nav : nav
   	};

}({});

