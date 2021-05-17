<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardUser;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();
        $all_users = User::all();
        $boards = Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }
        
        

        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards,
                'all_users' =>$all_users
            ]
        );
    }

    public function updateBoard(Request $request)
    {
          $error = '';
          $success = '';
          if ($request->has('id')) {
            /** @var User $user */
            $board = Board::find($request->get('id'));

            if ($board) {
                $name = $request->get('name');

                if (in_array($name, [User::ROLE_USER, User::ROLE_ADMIN])) {
                    $board->name = $name;
                    $board->save();

                    $success = 'Board saved';
                } else {
                    $error = 'Not valid!';
                }
            } else {
                $error = 'Board not found!';
            }
        } else {
            $error = 'Invalid request';
        }
        return redirect()->back()->with([
            'error' => $error, 'success' => $success
        ]);
    }
    /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    
    public function deleteBoard(Request $request) {
        Board::where('id',$request->deleteBoardId)->delete();
        return redirect(route('boards.all'));
      }

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board = clone $boards;
        $board = $board->where('id', $id)->first();

        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }

        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards
            ]
        );
    }
}
