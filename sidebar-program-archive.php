<?php
/**
 * The sidebar containing the main widget area.
 */

$selectedFilter = $_GET['filter'];
$selectedTerm = $_GET['term'];
?>

	<div class="content">
		<div style="text-align:center;">
			<input type="text" placeholder="search haven" id="textSearch"/>
			<input type="button" value="Search" id="btnProgramSearch"/>
			<input type="button" value="Clear" id="btnClearFilters"/>
		</div>
		<div class="filters" id="mainFilters">
			Search by:
			<div class="filter" id="mainFilter">
				<span class="arrow">icon</span>
				<span class="current">Date</span>
				<ul>
					<li data-slug="category" data-name="Category"><a href="javascript:;">Category</a></li>
					<li data-slug="series" data-name="Series"><a href="javascript:;">Series</a></li>
					<!-- <li data-slug="guest" data-name="Guest"><a href="javascript:;">Guest</a></li> -->
					<li data-slug="date" data-name="Date"><a href="javascript:;">Date</a></li>
				</ul>
			</div><!--end .filter-->
		</div><!--end .filters-->

		<div class="section archive filters" style="display:none;">
			<h1>Filters</h1>
			<hr class="blue" />
			<h2 id="filterHeaderText" style="color: #1d889a;">(Click on a letter or number to filter.)</h2>
			<h2 id="filterHeaderText">
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="0">0</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="1">1</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="2">2</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="3">3</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="4">4</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="5">5</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="6">6</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="7">7</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="8">8</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="9">9</a>
				&nbsp;|&nbsp;
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="A">A</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="B">B</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="C">C</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="D">D</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="E">E</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="F">F</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="G">G</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="H">H</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="I">I</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="J">J</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="K">K</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="L">L</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="M">M</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="N">N</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="O">O</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="P">P</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="Q">Q</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="R">R</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="S">S</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="T">T</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="U">U</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="V">V</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="W">W</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="X">X</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="Y">Y</a>
				<a href="javascript:void(0)" id="filter_0" data-filtervalue="Z">Z</a>
			</h2>
			<div class="checkboxes">
			</div><!--end .checkboxes-->
		</div>

		<div id="guestFilters" style="display:none;">
			<div class="filters">
				Select a Guest:
				<div class="filter" id="guestFilter" style="width:290px;">
					<span class="arrow">icon</span>
					<span class="current"></span>
					<ul style="width:303px;">
						<?php
							$terms = get_terms('speaker', array('hide_empty' => false));
							foreach ($terms as &$term) {
								echo '<li data-slug="'.$term->name.'" data-name="'.$term->name.'"><a href="javascript:;">'.$term->name.'</a></li>';
							}
						?>
					</ul>
				</div><!--end .filter-->
			</div>
		</div>

		<div id="dateFilters" style="display:none;">
			<div class="filters">
				Search by:
				<div class="filter" id="dateFilter">
					<span class="arrow">icon</span>
					<span class="current">Date</span>
					<ul>
						<li data-slug="1" data-name="1"><a href="javascript:;">1</a></li>
						<li data-slug="2" data-name="2"><a href="javascript:;">2</a></li>
						<li data-slug="3" data-name="3"><a href="javascript:;">3</a></li>
						<li data-slug="4" data-name="4"><a href="javascript:;">4</a></li>
						<li data-slug="5" data-name="5"><a href="javascript:;">5</a></li>
						<li data-slug="6" data-name="6"><a href="javascript:;">6</a></li>
						<li data-slug="7" data-name="7"><a href="javascript:;">7</a></li>
						<li data-slug="8" data-name="8"><a href="javascript:;">8</a></li>
						<li data-slug="9" data-name="9"><a href="javascript:;">9</a></li>
						<li data-slug="10" data-name="10"><a href="javascript:;">10</a></li>
						<li data-slug="11" data-name="11"><a href="javascript:;">11</a></li>
						<li data-slug="12" data-name="12"><a href="javascript:;">12</a></li>
						<li data-slug="13" data-name="13"><a href="javascript:;">13</a></li>
						<li data-slug="14" data-name="14"><a href="javascript:;">14</a></li>
						<li data-slug="15" data-name="15"><a href="javascript:;">15</a></li>
						<li data-slug="16" data-name="16"><a href="javascript:;">16</a></li>
						<li data-slug="17" data-name="17"><a href="javascript:;">17</a></li>
						<li data-slug="18" data-name="18"><a href="javascript:;">18</a></li>
						<li data-slug="19" data-name="19"><a href="javascript:;">19</a></li>
						<li data-slug="20" data-name="20"><a href="javascript:;">20</a></li>
						<li data-slug="21" data-name="21"><a href="javascript:;">21</a></li>
						<li data-slug="22" data-name="22"><a href="javascript:;">22</a></li>
						<li data-slug="23" data-name="23"><a href="javascript:;">23</a></li>
						<li data-slug="24" data-name="24"><a href="javascript:;">24</a></li>
						<li data-slug="25" data-name="25"><a href="javascript:;">25</a></li>
						<li data-slug="26" data-name="26"><a href="javascript:;">26</a></li>
						<li data-slug="27" data-name="27"><a href="javascript:;">27</a></li>
						<li data-slug="28" data-name="28"><a href="javascript:;">28</a></li>
						<li data-slug="29" data-name="29"><a href="javascript:;">29</a></li>
						<li data-slug="30" data-name="30"><a href="javascript:;">30</a></li>
						<li data-slug="31" data-name="31"><a href="javascript:;">31</a></li>
					</ul>
				</div><!--end .filter-->
				<div class="filter" id="monthFilter">
					<span class="arrow">icon</span>
					<span class="current">Month</span>
					<ul>
						<li data-slug="1" data-name="January"><a href="javascript:;">January</a></li>
						<li data-slug="2" data-name="February"><a href="javascript:;">February</a></li>
						<li data-slug="3" data-name="March"><a href="javascript:;">March</a></li>
						<li data-slug="4" data-name="April"><a href="javascript:;">April</a></li>
						<li data-slug="5" data-name="May"><a href="javascript:;">May</a></li>
						<li data-slug="6" data-name="June"><a href="javascript:;">June</a></li>
						<li data-slug="7" data-name="July"><a href="javascript:;">July</a></li>
						<li data-slug="8" data-name="August"><a href="javascript:;">August</a></li>
						<li data-slug="9" data-name="September"><a href="javascript:;">September</a></li>
						<li data-slug="10" data-name="October"><a href="javascript:;">October</a></li>
						<li data-slug="11" data-name="November"><a href="javascript:;">November</a></li>
						<li data-slug="12" data-name="December"><a href="javascript:;">December</a></li>
					</ul>
				</div><!--end .filter-->
				<div class="filter" id="yearFilter">
					<span class="arrow">icon</span>
					<span class="current">Year</span>
					<ul>
						<li data-slug="2015" data-name="2015"><a href="javascript:;">2015</a></li>
						<li data-slug="2014" data-name="2014"><a href="javascript:;">2014</a></li>
						<li data-slug="2013" data-name="2013"><a href="javascript:;">2013</a></li>
						<li data-slug="2012" data-name="2012"><a href="javascript:;">2012</a></li>
						<li data-slug="2011" data-name="2011"><a href="javascript:;">2011</a></li>
					</ul>
				</div><!--end .filter-->
			</div><!--end .filters-->

			<a href="javascript:;" class="outlineBtn">Done</a>
		</div>
		<div class="items" style="display: none;">
			<div class="arrowLeft"><span>previous</span></div>
			<div class="arrowRight"><span>next</span></div>
			<div class="inner">
			</div><!--end .inner-->
		</div><!--end .items-->
	</div><!--end .content-->
	<div id="hiddenTerm" data-term="<?php echo $selectedTerm ?>"></div>
	<div id="hiddenFilter" data-filter="<?php echo $selectedFilter ?>"></div>
