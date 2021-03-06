<?php

	class Radio extends CI_Controller {

	public function index()
	{
		// Check Auth
		$this->load->model('user_model');
		if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }
		
		// load the view
		$data['page_title'] = "Radio Status";

		$this->load->view('layout/header', $data);
		$this->load->view('radio/index');
		$this->load->view('layout/footer');
	}
	
	function status() {
	
		// Check Auth
		$this->load->model('user_model');
		if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }
	
		$this->load->model('cat');
		$query = $this->cat->status();
		if ($query->num_rows() > 0)
		{
			echo "<tr class=\"titles\">";
				echo "<td>Radio</td>";
				echo "<td>Frequency</td>";
				echo "<td>Mode</td>";
				echo "<td>Timestamp</td>" ;
				echo "<td>Options</td>";
			echo "</tr>";
			foreach ($query->result() as $row)
			{
				echo "<tr>";
				echo "<td>".$row->radio."</td>";
				echo "<td>".$row->frequency."</td>";
				echo "<td>".$row->mode."</td>";
				echo "<td>".$row->timestamp."</td>" ;
				echo "<td><a href=\"".site_url('radio/delete')."/".$row->id."\" ><img src=\"".base_url()."/images/delete.png\" width=\"16\" height=\"16\" alt=\"Delete\" /></a></td>" ;
				echo "</tr>";
			}
		} else {
			echo "<tr>";
				echo "<td colspan=\"4\">No CAT Interfaced radios found.</td>";
			echo "</tr>";
		}
			
	}
	
	function frequency($id) {

		// Check Auth
		$this->load->model('user_model');
		if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }

		//$this->db->where('radio', $result['radio']); 
			$this->db->select('frequency');
			$this->db->where('id', $id); 
			$query = $this->db->get('cat');
			
			if ($query->num_rows() > 0)
			{
			   foreach ($query->result() as $row)
				{
					echo $row->frequency;
				}
			}
	}
	
	function mode($id) {
	
		// Check Auth
		$this->load->model('user_model');
		if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }

		//$this->db->where('radio', $result['radio']); 
			$this->db->select('mode');
			$this->db->where('id', $id); 
			$query = $this->db->get('cat');
			
			if ($query->num_rows() > 0)
			{
			   foreach ($query->result() as $row)
				{
					echo strtoupper($row->mode);
				}
			}
	}
	
	function delete($id) {
		// Check Auth
		$this->load->model('user_model');
		if(!$this->user_model->authorize(99)) { $this->session->set_flashdata('notice', 'You\'re not allowed to do that!'); redirect('dashboard'); }
		
		$this->load->model('cat');
		
		$this->cat->delete($id);
		
		$this->session->set_flashdata('message', 'Radio Profile Deleted');
		
		redirect('radio');

	}
}

?>