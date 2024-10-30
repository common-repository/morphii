<?php 
require MORPHII_ASSETS_URL.'/libs/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_GET['action']) && $_GET['action'] == 'export-reviews'){

                  $args = array(
                      'post_type'=> 'morphii-reviews',
                      'post_status' => 'publish',
                      'posts_per_page' => -1,
                      'order' => 'ASC'
                  );  
                  $the_query = new WP_Query( $args );
                                  
                  $styleArray = array(
                      'font' => array(
                      'bold' => true
                      ),
                      'alignment' => array(
                              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                          )
                  );
                  $spreadsheet = new Spreadsheet();

                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A1', 'Post Name');
                  $sheet->setCellValue('B1', 'Date');
                  $sheet->setCellValue('C1', 'Post Type');
                  $sheet->setCellValue('D1', 'Question');
                  $sheet->setCellValue('E1', 'Morphii');
                  $sheet->setCellValue('F1', 'Morphii Intensity');
                  $rows = 3;
                  $serial = 1;

                  $sheet->getStyle('A1')->applyFromArray($styleArray);
                  $sheet->getStyle('B1')->applyFromArray($styleArray);
                  $sheet->getStyle('C1')->applyFromArray($styleArray);
                  $sheet->getStyle('D1')->applyFromArray($styleArray);
                  $sheet->getStyle('E1')->applyFromArray($styleArray);
                  $sheet->getStyle('F1')->applyFromArray($styleArray);

                  $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
                  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20, 'pt');
                  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10, 'pt');
                  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20, 'pt');
                  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30, 'pt');
                  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30, 'pt');
                  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30, 'pt');

                  $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');
                  $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');
                  $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');
                  $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');
                  $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');
                  $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('919299');

                  $spreadsheet->getActiveSheet()->getStyle('A1:F1')
              ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

                  $spreadsheet->getActiveSheet()->getStyle('A:F')
                      ->getAlignment()->setWrapText(true);

                  $spreadsheet->getActiveSheet()->getStyle('A:F')
                      ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                  if($the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : 
                      $the_query->the_post(); 

                        $post_id = get_the_ID();
                        $current_post_name = get_post_meta($post_id,'morphii-current-post_name',true);
                        $post_type_review = get_post_meta($post_id,'morphii-current-post_type',true);
                        $morphii_final_review = get_post_meta($post_id,'_morphii_final_review',true);
                        $post_date = get_the_time('Y-m-d', $post_id);

                        $sheet->setCellValue('A' . $rows, $current_post_name);
                        $sheet->setCellValue('B' . $rows, $post_date);
                        $sheet->setCellValue('C' . $rows, $post_type_review);

                        if(!empty($morphii_final_review)){
                            $morphii_final_review_array = json_decode($morphii_final_review);
                            foreach ($morphii_final_review_array as $key => $review) {
                              $intensity =  $review->reaction_record->morphii->intensity;
                              $percent = round((float)$intensity * 100 ) . '%';


                              $sheet->setCellValue('D' . $rows, $review->reaction_record->target->metadata[2]->value);
							  $part_name=(strtolower($review->reaction_record->morphii->part_name)!=strtolower($review->reaction_record->morphii->name))?ucfirst($review->reaction_record->morphii->part_name):$review->reaction_record->morphii->name;
								
                              $sheet->setCellValue('E' . $rows, $part_name);
                              $sheet->setCellValue('F' . $rows, $percent);
                              $rows = $rows+2;
                            }
                        }
                    endwhile;
                  endif;
                  $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;

                  foreach($sheet->getRowIterator() as $row) {
                    foreach($row->getCellIterator() as $cell) {
                      $cellCoordinate = $cell->getCoordinate();
                        $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal($alignment_center);
                      }
                  }
                  $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
                  $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
                  ob_end_clean();
                  //header('Content-Type: application/vnd.ms-excel');
                  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                  
                  header('Content-Disposition: attachment; filename="morphiireviews.xlsx"');
                  $writer->save('php://output');
                  exit();
}
                  if ( ! current_user_can( 'manage_options' ) ) {
                      return;
                  }
                  $default_tab = null;
                  $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab;
                  if(!empty(get_option( 'morphii-settings' ))){
                    $settings = json_decode(get_option( 'morphii-settings' ));
                  } 
                  if(!empty(get_option( 'morphii-licence' ))){
                    $licence = json_decode(get_option( 'morphii-licence' ));
                  }?>
<div class="wrap">
    <h1>Settings</h1>
    <nav class="nav-tab-wrapper">
      <a href="?page=morphii-settings" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif;?>">General Settings</a>
      <a href="?page=morphii-settings&tab=shortcode" class="nav-tab <?php if($tab==='shortcode'):?>nav-tab-active<?php endif;?>">Shortcode</a>
      <a href="?page=morphii-settings&tab=licence" class="nav-tab <?php if($tab==='licence'):?>nav-tab-active<?php endif;?>">License</a>
      <a href="?page=morphii-settings&tab=reports" class="nav-tab <?php if($tab==='reports'):?>nav-tab-active<?php endif;?>">Reports</a>
    </nav>
    <div class="tab-content">
    <?php switch($tab) :
      case 'shortcode':?>
        <div class="wrap">
            <h2><?php _e( 'Morphii Shortcode', 'morphii' ) ?></h2>            
            <h2>Shortcode Details</h2>
            <p class="morphii-desc">Use the below shortcode to get reviews from your different pages or posts or other post types.</p>
            <table class="form-table">
              <tbody>
                <tr class="morphii_shortcode-wrap">
                    <th><label for="shortcode">Shortcode:</label></th>
                </tr>                
                <tr class="morphii_shortcode-wrap">
                    <th class="shortcode-data"><label for="shortcode">[morphii-reviews]</label></th>
                </tr>
                <tr class="morphii_shortcode-wrap">
                    <th><label for="shortcode">Display selected questions on page or post or custom post: (Add your question ids in comma separated form)</label></th>
                </tr>                
                <tr class="morphii_shortcode-wrap">
                    <th class="shortcode-data"><label for="shortcode">[morphii-reviews question_ids="MWP400"]</label></th>
                </tr>
              </tbody>
            </table> 
        <?php
        break;
      case 'licence':?>
        <div class="wrap">
            <h2><?php _e( 'Morphii License', 'morphii' ) ?></h2>            
            <h2>License Details</h2>
            <form method="post"novalidate="novalidate">
              <table class="form-table">
                  <tbody>
                      <tr class="morphii_account_id-wrap">
                          <th><label for="morphii_account_id">Morphii Account ID</label></th>
                          <td><input type="text" name="morphii_account_id" value="<?php if(isset($licence) && $licence->morphii_account_id != ""){ echo $licence->morphii_account_id;} ?>" class="regular-text"> </td>
                      </tr>                              
                      <tr class="morphii_account_key-wrap">
                          <th><label for="morphii_account_key">Morphii Account Key</label></th>
                          <td><input type="text" name="morphii_account_key" value="<?php if(isset($licence) && $licence->morphii_account_key != ""){ echo $licence->morphii_account_key;} ?>" class="regular-text"></td>
                      </tr>
                  </tbody>
              </table>
             <p class="submit"><input type="submit" name="morphii-licence-submit" id="submit" class="button button-primary" value="Save Changes"></p></form>
             <p class="morphii-desc">If you don't have Account id and License Key for morphii.Please click below to get that.</p>
             <p class="morphii-desc"><a href="https://wp-account.morphii.com/?d=<?php echo get_bloginfo('wpurl'); ?>" class="morphii-licence-domain" target="_blank">Get Your Morphii License Key</a></p>
        </div>
        <?php
        break;
      case 'reports':?>
        <div class="wrap">
            <h2><?php _e( 'Morphii Reports', 'morphii' ) ?></h2>
            <?php
            $args_free = array(
                    'post_type'=> 'morphii-reviews',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'order' => 'ASC'
                );  
            $the_query_free = new WP_Query( $args_free );
            if($the_query_free->have_posts() ) {?>
              <h2>Export all reviews</h2>

              <p class="morphii-desc"><a href="?page=morphii-settings&tab=reports&action=export-reviews" class="morphii-licence-domain" target="_blank">Export All Reviews</a></p>

              <?php } else { ?>
              <h2>Export all reviews</h2>
              <table class="form-table">
              <tbody>
                <tr class="morphii_shortcode-wrap">
                    <th><label for="shortcode">You can't export the reviews as you don't have any reviews yet!</label></th>
                </tr>
              </tbody>
            </table>       
            <?php } ?>
        </div>
        <?php break;
      default: ?>
        <form method="post"novalidate="novalidate">
          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <th scope="row"><label for="blogname">Enable Text Reviews</label></th>
                <td>
                  <input name="enable-text-reviews" type="checkbox" id="enable-text-reviews" value="<?php if(isset($settings) && $settings->enable_text_reviews == 'yes'){ echo "yes";} else { echo "no";}?>" <?php if(isset($settings) && $settings->enable_text_reviews == 'yes'){ echo "checked";}?> class="regular-text" disabled />
                  <p class="description" id="tagline-description">The Text Feedback feature is locked and disabled in the Free version of the Morphii plugin for Wordpress. Upgrade to Pro to use this feature.</p>
                </td>
              </tr>
              <tr>
                <th scope="row"><label for="blogname">Select Font Family</label></th>
                <td>
                  <select id="morphii-font-family" name="morphii-font-family" aria-describedby="morphii-font-family-description">
                  <option value="inherit">Default</option>
                  <option value="Agency FB" style="font-family: Agency FB;" <?php if(isset($settings) && $settings->morphii_font_family == 'Agency FB'){ echo "selected";}?>>Agency FB</option>
                  <option value="Albertina" style="font-family: Albertina;" <?php if(isset($settings) && $settings->morphii_font_family == 'Albertina'){ echo "selected";}?>>Albertina</option>
                  <option value="Antiqua" style="font-family: Antiqua;" <?php if(isset($settings) && $settings->morphii_font_family == 'Antiqua'){ echo "selected";}?>>Antiqua</option>
                  <option value="Architect" style="font-family: Architect;" <?php if(isset($settings) && $settings->morphii_font_family == 'Architect'){ echo "selected";}?>>Architect</option>
                  <option value="Arial" style="font-family: Arial;" <?php if(isset($settings) && $settings->morphii_font_family == 'Arial'){ echo "selected";}?>>Arial</option>
                  <option value="BankFuturistic" style="font-family: BankFuturistic;" <?php if(isset($settings) && $settings->morphii_font_family == 'BankFuturistic'){ echo "selected";}?>>BankFuturistic</option>
                  <option value="BankGothic" style="font-family: BankGothic;" <?php if(isset($settings) && $settings->morphii_font_family == 'BankGothic'){ echo "selected";}?>>BankGothic</option>
                  <option value="Blackletter" style="font-family: Blackletter;" <?php if(isset($settings) && $settings->morphii_font_family == 'Blackletter'){ echo "selected";}?>>Blackletter</option>
                  <option value="Blagovest" style="font-family: Blagovest;" <?php if(isset($settings) && $settings->morphii_font_family == 'Blagovest'){ echo "selected";}?>>Blagovest</option>
                  <option value="Calibri" style="font-family: Calibri;" <?php if(isset($settings) && $settings->morphii_font_family == 'Calibri'){ echo "selected";}?>>Calibri</option>
                  <option value="Comic Sans MS" style="font-family: Comic Sans MS;" <?php if(isset($settings) && $settings->morphii_font_family == 'Comic Sans MS'){ echo "selected";}?>>Comic Sans MS</option>
                  <option value="Consolas" style="font-family: Consolas;" <?php if(isset($settings) && $settings->morphii_font_family == 'Consolas'){ echo "selected";}?>>Consolas</option>
                  <option value="Courier" style="font-family: Courier;" <?php if(isset($settings) && $settings->morphii_font_family == 'Courier'){ echo "selected";}?>>Courier</option>
                  <option value="Garamond" style="font-family: Garamond;" <?php if(isset($settings) && $settings->morphii_font_family == 'Garamond'){ echo "selected";}?>>Garamond</option>
                  <option value="Georgia" style="font-family: Georgia;" <?php if(isset($settings) && $settings->morphii_font_family == 'Georgia'){ echo "selected";}?>>Georgia</option>
                  <option value="Helvetica" style="font-family: Helvetica;" <?php if(isset($settings) && $settings->morphii_font_family == 'Helvetica'){ echo "selected";}?>>Helvetica</option>
                  <option value="Impact" style="font-family: Impact;" <?php if(isset($settings) && $settings->morphii_font_family == 'Impact'){ echo "selected";}?>>Impact</option>
                  <option value="Minion" style="font-family: Minion;" <?php if(isset($settings) && $settings->morphii_font_family == 'Minion'){ echo "selected";}?>>Minion</option>
                  <option value="Modern" style="font-family: Modern;" <?php if(isset($settings) && $settings->morphii_font_family == 'Modern'){ echo "selected";}?>>Modern</option>
                  <option value="Open Sans" style="font-family: Open Sans;" <?php if(isset($settings) && $settings->morphii_font_family == 'Open Sans'){ echo "selected";}?>>Open Sans</option>
                  <option value="Palatino" style="font-family: Palatino;" <?php if(isset($settings) && $settings->morphii_font_family == 'Palatino'){ echo "selected";}?>>Palatino</option>
                  <option value="Perpetua" style="font-family: Perpetua;" <?php if(isset($settings) && $settings->morphii_font_family == 'Perpetua'){ echo "selected";}?>>Perpetua</option>
                  <option value="Swiss" style="font-family: Swiss;" <?php if(isset($settings) && $settings->morphii_font_family == 'Swiss'){ echo "selected";}?>>Swiss</option>
                  <option value="Tahoma" style="font-family: Tahoma;" <?php if(isset($settings) && $settings->morphii_font_family == 'Tahoma'){ echo "selected";}?>>Tahoma</option>
                  <option value="Times" style="font-family: Times;" <?php if(isset($settings) && $settings->morphii_font_family == 'Times'){ echo "selected";}?>>Times</option>
                  <option value="Times New Roman" style="font-family: Times New Roman;" <?php if(isset($settings) && $settings->morphii_font_family == 'Times New Roman'){ echo "selected";}?>>Times New Roman</option>
                  <option value="Tw Cen MT" style="font-family: Tw Cen MT;" <?php if(isset($settings) && $settings->morphii_font_family == 'Tw Cen MT'){ echo "selected";}?>>Tw Cen MT</option>
                  <option value="Verdana" style="font-family: Verdana;" <?php if(isset($settings) && $settings->morphii_font_family == 'Verdana'){ echo "selected";}?>>Verdana</option>
                  </select>
                  <p class="description" id="tagline-description">You can select font family for your morphii review form.</p>
                </td>
              </tr>
              <tr>
                <th scope="row"><label for="blogname">Submit Button Text</label></th>
                <td>
                  <input type="text" name="morphii-submit-button-text" value="<?php if(!empty($settings->morphii_submit_button_text)){ echo $settings->morphii_submit_button_text;} else { echo "Submit";}?>" class="regular-text"  />
                  <p class="description" id="tagline-description">You can change submit button text from here.</p>
                </td>
              </tr>
              <tr>
                <th scope="row"><label for="blogname">Select Submit Button Color</label></th>
                <td>
                  <input type="text" value="<?php if(!empty($settings->morphii_submit_color)){ echo $settings->morphii_submit_color;} else { echo "#ffc940";}?>" name="morphii-submit-color" class="my-color-field regular-text" data-default-color="#ffc940" />
                  <p class="description" id="tagline-description">You can change submit button color from here.</p>
                </td>
              </tr>
              <tr>
                <th scope="row"><label for="blogname">Question Font Size </label></th>
                <td>
                  <select id="morphii-font-family" name="morphii-question-font-size" aria-describedby="morphii-font-family-description">
                  <option value="16px">Default</option>
                  <option value="9px" <?php if(isset($settings) && $settings->morphii_question_font_size == '9px'){ echo "selected";}?>>9 px</option>
                  <option value="10px" <?php if(isset($settings) && $settings->morphii_question_font_size == '10px'){ echo "selected";}?>>10 px</option>
                  <option value="11px" <?php if(isset($settings) && $settings->morphii_question_font_size == '11px'){ echo "selected";}?>>11 px</option>
                  <option value="12px" <?php if(isset($settings) && $settings->morphii_question_font_size == '12px'){ echo "selected";}?>>12 px</option>
                  <option value="13px" <?php if(isset($settings) && $settings->morphii_question_font_size == '13px'){ echo "selected";}?>>13 px</option>
                  <option value="14px" <?php if(isset($settings) && $settings->morphii_question_font_size == '14px'){ echo "selected";}?>>14 px</option>
                  <option value="15px" <?php if(isset($settings) && $settings->morphii_question_font_size == '15px'){ echo "selected";}?>>15 px</option>
                  <option value="16px" <?php if(isset($settings) && $settings->morphii_question_font_size == '16px'){ echo "selected";}?>>16 px</option>
                  <option value="18px" <?php if(isset($settings) && $settings->morphii_question_font_size == '18px'){ echo "selected";}?>>18 px</option>
                  <option value="20px" <?php if(isset($settings) && $settings->morphii_question_font_size == '20px'){ echo "selected";}?>>20 px</option>
                  <option value="22px" <?php if(isset($settings) && $settings->morphii_question_font_size == '22px'){ echo "selected";}?>>22 px</option>
                  </select>
                  <p class="description" id="tagline-description">You can change question fornt size from here.</p>
                </td>
              </tr>
            </tbody>
          </table>
          <p class="submit"><input type="submit" name="morphii-option-submit" id="submit" class="button button-primary" value="Save Changes"></p></form>
        <?php
        break;
      endswitch;?>
    </div>
</div>
<?php
if(isset($_POST['morphii-option-submit'])){
  $options = array(
    'enable_text_reviews' => sanitize_text_field($_POST['enable-text-reviews']),
    'morphii_font_family' => sanitize_text_field($_POST['morphii-font-family']),
    'morphii_submit_button_text' => sanitize_text_field($_POST['morphii-submit-button-text']),
    'morphii_submit_color' => sanitize_text_field($_POST['morphii-submit-color']),
    'morphii_question_font_size' => sanitize_text_field($_POST['morphii-question-font-size'])
  );
  $newoption = json_encode($options);
  if(update_option( 'morphii-settings', $newoption)){
    echo "Changes saved successfully.";
    echo "<script>location.href='".admin_url('/admin.php?page=morphii-settings')."';</script>";
  }else{
    echo "Error occured.Please try again later.";
  }
}

if(isset($_POST['morphii-licence-submit'])){
  $options = array(
    'morphii_account_id' => sanitize_text_field($_POST['morphii_account_id']),
    'morphii_account_key' => sanitize_text_field($_POST['morphii_account_key'])
  );
  $newoption = json_encode($options);
  if(update_option( 'morphii-licence', $newoption)){
    echo "Changes saved successfully.";
    echo "<script>location.href='".admin_url('/admin.php?page=morphii-settings&tab=licence')."';</script>";
  }else{
    echo "Error occured.Please try again later.";
  }
}