<?php

namespace Database\Seeders;

use App\Models\SelectOption;
use Illuminate\Database\Seeder;

class SelectOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SelectOption::insert([
            [
                'option_name' => 'Special',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo Special',
                'tag' => 'special_field_option'
            ],
            [
                'option_name' => 'No Special',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo No Special',
                'tag' => 'no_special_field_option'
            ],
            [
                'option_name' => 'Hidden',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo Hidden',
                'tag' => 'hidden_field_option'
            ],
            [
                'option_name' => 'Captcha',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo Captcha',
                'tag' => 'captcha_field_option'
            ],
            [
                'option_name' => 'Geolocation',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo Geolocation',
                'tag' => 'geolocation_field_option'
            ],
            [
                'option_name' => 'File',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo File',
                'tag' => 'file_field_option'
            ],
            [
                'option_name' => 'Text',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo Text',
                'tag' => 'text_field_option'
            ],
            [
                'option_name' => 'Text area',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'text_area_field_option'
            ],
            [
                'option_name' => 'Number',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'number_field_option'
            ],
            [
            'option_name' => 'Email',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'email_field_option'
            ],
            [
                'option_name' => 'Password',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'password_field_option'
            ],
            [
                'option_name' => 'Formula',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'formula_field_option'
            ],
            [
                'option_name' => 'Hyperlink',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'hyperlink_field_option'
            ],
            [
                'option_name' => 'Date',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'date_field_option'
            ],
            [
                'option_name' => 'Time',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'time_field_option'
            ],
            [
                'option_name' => 'Boolean',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'boolean_field_option'
            ],
            [
                'option_name' => 'Range',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'range_field_option'
            ],
            [
                'option_name' => 'Dropdown',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'dropdown_field_option'
            ],
            [
                'option_name' => 'Checkbox',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'checkbox_field_option'
            ],
            [
                'option_name' => 'Radio Button',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'radio_button_field_option'
            ],
            [
                'option_name' => 'Rating',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'rating_field_option'
            ],
            [
                'option_name' => 'Payment',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'payment_field_option'
            ],
            [
                'option_name' => 'Color picker',
                'option_kind' => 'field',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'color_picker_field_option'
            ],
            [
                'option_name' => 'Open',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'open_status_option'
            ],
            [
                'option_name' => 'In Progress',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'in_progress_status_option'
            ],
            [
                'option_name' => 'In Approval',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'in_approval_status_option'
            ],
            [
                'option_name' => 'On Hold',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'on_hold_status_option'
            ],
            [
                'option_name' => 'Pending',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'pending_status_option'
            ],
            [
                'option_name' => 'Approved',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'approved_status_option'
            ],
            [
                'option_name' => 'Rejected',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'rejected_status_option'
            ],
            [
                'option_name' => 'Resolved',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'resolved_status_option'
            ],
            [
                'option_name' => 'Closed',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'closed_status_option'
            ],
            [
                'option_name' => 'Reopened',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'reopened_status_option'
            ],
            [
                'option_name' => 'Escalated',
                'option_kind' => 'status',
                'tooltip' => 'Tooltip Demo',
                'placeholder' => 'Placeholder Demo',
                'description' => 'Description Demo',
                'tag' => 'escalated_status_option'
            ],
        ]);
    }
}
