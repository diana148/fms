<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated to access settings
    }

    /**
     * Display the settings page.
     * Fetches the current default currency from the AppSettings.
     */
    public function index()
    {
        // Retrieve the default currency setting.
        // Provides 'TZS' as a fallback if the setting hasn't been saved yet.
        $defaultCurrency = AppSetting::getSetting('default_currency', 'TZS');

        // Pass the retrieved setting to the view.
        return view('settings.index', compact('defaultCurrency'));
    }

    /**
     * Update the application settings.
     * Validates and saves the new default currency.
     */
    public function update(Request $request)
    {
        // Validate the incoming request data.
        // Ensures 'default_currency' is present and one of 'TZS' or 'USD'.
        $request->validate([
            'default_currency' => 'required|in:TZS,USD',
        ]);

        // Save the updated default currency to the app_settings table.
        AppSetting::setSetting('default_currency', $request->input('default_currency'));

        // Redirect back to the settings page with a success message.
        return redirect()->route('settings.index')->with('success', 'Default currency updated successfully.');
    }
}
