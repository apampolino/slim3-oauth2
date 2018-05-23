<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Extensions\SlimPagination as Pagination;
use \App\Controllers\SlimController;
use \App\Models\Blog;

class BlogController extends SlimController {

    public function index(Request $request, Response $response, array $args) {

        $page = !empty($request->getParam('page')) ? (int) $request->getParam('page') : 1;

        $perPage = ($request->getParam('perPage')) ? (int) $request->getParam('perPage') : 5;

        $blogs = Blog::orderBy('id', 'DESC')->get();

        $total = count($blogs);

        $options = ['path' => 'blog', 'url' => 'blog/'];

        $paginator = new Pagination($blogs, $total, $perPage, $page, $options);

        $this->container->view->render($response, 'blog/index.html.twig', compact('paginator'));
    }

    public function create(Request $request, Response $response, array $args) {

        $this->container->view->render($response, 'blog/create.html.twig', array());
    }

    public function show(Request $request, Response $response, array $args) {

        $blog = Blog::find($args['id']);

        if ($blog) {

            $this->container->view->render($response, 'blog/show.html.twig', compact('blog'));

        } else {

            return $response->withRedirect('/blog');
        }
    }

    public function edit(Request $request, Response $response, array $args) {

        $blog = $blog = Blog::find($args['id']);

        if ($blog) {

            $this->container->view->render($response, 'blog/edit.html.twig', compact('blog'));
            
        } else {

            return $response->withRedirect('/blog');
        }
    }

    public function store(Request $request, Response $response, array $args) {

        $params = $request->getParsedBody();

        $blog = new Blog;

        $blog->title = $params['title'];

        $blog->body = $params['body'];

        $blog->name = $params['name'];

        $blog->email = $params['email'];

        $blog->save();

        return $response->withRedirect('/blog');
    }

    public function update(Request $request, Response $response, array $args) {

        $params = $request->getParsedBody();

        $blog = $blog = Blog::find($args['id']);

        $blog->title = $params['title'];

        $blog->body = $params['body'];

        $blog->name = $params['name'];

        $blog->email = $params['email'];

        $blog->save();

        return $response->withRedirect('/blog');
    }

    public function delete(Request $request, Response $response, array $args) {

        $blog = Blog::find($args['id'])->delete();

        return $response->withRedirect('/blog');
    }
}