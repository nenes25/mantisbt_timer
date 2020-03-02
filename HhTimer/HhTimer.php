<?php
# MantisBT - A PHP based bugtracking system
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.
class HhTimerPlugin extends MantisPlugin
{

    public function register()
    {
        $this->name = plugin_lang_get('title');
        $this->description = plugin_lang_get('description');
        $this->version = '0.1.0';
        $this->requires = array(
            'MantisCore' => '2.0.0',
        );

        $this->author = 'Hennes Hervé';
        $this->contact = 'contact@h-hennes.fr';
        $this->url = 'https://www.h-hennes.fr/blog/';
    }

    /**
     * plugin hooks
     * @return array
     */
    public function hooks()
    {
        return array(
            'EVENT_BUGNOTE_ADD_FORM' => 'bugnote_add_form',
            'EVENT_LAYOUT_RESOURCES' => 'resources',
        );

    }

    /**
     * Add Timer under the bugnote add form
     * @param $eventName
     * @param $bug_id
     */
    public function bugnote_add_form($eventName, $bug_id)
    {
        if ( $this->shouldDisplay()) {
            echo '
            <tr>
                <th class="category">' . plugin_lang_get('timer') . '</th>
                <td>
                    <div id="note-timer">
                       <div class="timer"></div>
                       <div>
                            <button class="btn btn-success startButton">' . plugin_lang_get('start') . '</button>
                            <button class="btn btn-warning pauseButton" >' . plugin_lang_get('pause') . '</button>
                            <button class="btn btn-danger stopButton">' . plugin_lang_get('stop') . '</button>
                            <button class="btn btn-dark resetButton">' . plugin_lang_get('reset') . '</button>
                       </div>
                    </div>
                </td>
            </tr>
            ';
        }
    }

    /**
     * Add js to configure timer on bug view page
     */
    public function resources(){
        if ( helper_mantis_url( 'view.php' ) == $_SERVER['PHP_SELF'] ) {
            echo '<script src="' . plugin_file("easytimer.min.js") . '"></script>';
            echo '<script src="' . plugin_file("easytimer_config.js") . '"></script>';
        }
    }

    /**
     * Check if timer can be displayed
     * @return bool
     */
    private function shouldDisplay()
    {
        $t_current_project = helper_get_current_project();
        $t_project_id = gpc_get_int('project_id', $t_current_project);
        $t_timetracking_enabled = config_get('time_tracking_enabled', null, null, $t_project_id);

        return ( $t_timetracking_enabled == ON && current_user_get_access_level() >= DEVELOPER );
    }

}