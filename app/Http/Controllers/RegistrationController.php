namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phoneNo' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phoneNo' => $data['phoneNo'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function registered(Request $request)
    {
        // Validate the incoming request data
        $this->validator($request->all())->validate();

        // Create the user
        $user = $this->create($request->all());

        // Redirect to the home page or any other page you want
        return redirect()->route('login');
    }
}
