<?php

namespace App\Http\Controllers;

use App\Chatroom;
use App\Det_Chat;
use App\Inbox;
use App\Outbox;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use DB;


class ChatsController extends Controller
{
    public function __construct()
	{
	  $this->middleware('auth');
	}

	public function index()
	{
	  return view('chat');
	}

	public function fetchMessages(Request $request)
	{
			$receiver=Auth::user()->id;
			// return $sender;
			$inbox=DB::table('inbox')
			->select('users.*','a.name AS senderName','inbox.messages','inbox.receiver','inbox.sender', 'inbox.created_at AS created2')
			// ->join('chatroom','chatroom.id','=','inbox.id_chatroom')
			->join('users','users.id','=','inbox.receiver')
			->join('users as a','a.id','=','inbox.sender')
			->where([['sender',$request->sender],['receiver',$receiver],['id_chatroom',$request->chat_id]]);
			// ->orWhere([['sender',$receiver],['receiver',$request->sender],['id_chatroom',$request->chat_id]]);

			$outbox=DB::table('outbox')
			->select('users.*','a.name AS senderName','outbox.messages','outbox.receiver','outbox.sender', 'outbox.created_at AS created1')
			// ->join('chatroom','chatroom.id','=','outbox.id_chatroom')
			->join('users','users.id','=','outbox.receiver')
			->join('users as a','a.id','=','outbox.sender')
			->where([['sender',$receiver],['receiver',$request->sender],['id_chatroom',$request->chat_id]])
			// ->orWhere([['sender',$request->sender],['receiver',$receiver],['id_chatroom',$request->chat_id]])
			->union($inbox)
			->orderBy('created1', 'asc')
			->get();
			return $outbox;
	}

	public function sendMessage(Request $request)
	{
	  $user = Auth::user();
		$userReceiver=User::find($request->user2);
		$messageIn = new Inbox();
		$messageIn->sender = Auth::user()->id;
		$messageIn->receiver =$request->user2;
		$messageIn->id_chatroom = $request->chat_id;
		$messageIn->messages = $request->messages;
		$messageIn->save();

		$messageOut = new Outbox();
		$messageOut->sender = Auth::user()->id;
		$messageOut->receiver = $request->user2;
		$messageOut->id_chatroom = $request->chat_id;
		$messageOut->messages = $request->messages;
		$messageOut->save();

	  return ['status' => 'Message Sent!'];
	}

	public function userMessages($friend){
		$user=Auth::user()->id;
		// return $friend;
		$inbox=DB::table('inbox')->where([['sender',$friend],['receiver',$user]]);
		$outbox=DB::table('outbox')->where([['sender',$user],['receiver',$friend]])
		->union($inbox)
		->orderBy('created_at', 'asc')
		->get();
		return $outbox;
	}

	public function createChat(Request $request) {
		$user_1 = Auth::user()->id;
		// return $user1;
		$countChat = Chatroom::where('user1', $user_1)
				->where('user2', $request->user2)
				->orWhere(function($q) use($request,$user_1) {
						$q->where('user1', $request->user2)
						->where('user2', $user_1);
				})
		->get();
		
		// return $countChat->count();

		if($countChat->count() < 1){
				$chatRoom = new Chatroom();
				$chatRoom->user1 = $user_1;
				$chatRoom->user2 = $request->user2;
				$chatRoom->save();
				
				$idChat = DB::table('chatroom')
						->select('id')
						->where('user1',$user_1)
						->where('user2',$request->user2)
						->first();
				return $idChat->id;

		}else{
				$idChat = Chatroom::select('id')
				->where('user1', $user_1)
				->where('user2', $request->user2)
				->orWhere(function($q) use($request,$user_1) {
						$q->where('user1', $request->user2)
						->where('user2', $user_1);
				})->first();
				return $idChat->id;
				
		}
	}
}
