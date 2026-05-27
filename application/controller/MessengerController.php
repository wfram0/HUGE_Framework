<?php
class MessengerController extends Controller
{
    public function index()
    {
        $this->View->render('messenger/index');
    }

    public function chat($receiver_id)
    {
        Session::init();

        $current_user_id = Session::get('user_id');

        // mark received messages as read
        MessageModel::markMessagesAsRead(
            $receiver_id,
            $current_user_id
        );

        // load conversation
        $messages = MessageModel::getConversation(
            $current_user_id,
            $receiver_id
        );

        $this->View->render('messenger/chat', array(
            'messages' => $messages,
            'receiver_id' => $receiver_id
        ));
    }

    public function send()
    {
        Session::init();

        $sender_id = Session::get('user_id');

        if (isset($_POST['receiver_id']) && isset($_POST['message'])) {

            MessageModel::sendMessage(
                $sender_id,
                $_POST['receiver_id'],
                trim($_POST['message'])
            );

            Redirect::to(
                'messenger/chat/' . $_POST['receiver_id']
            );
        }
    }
}
?>