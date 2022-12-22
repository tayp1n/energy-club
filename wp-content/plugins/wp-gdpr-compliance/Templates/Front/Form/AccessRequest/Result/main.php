<?php

use WPGDPRC\Objects\Data\Data;

/**
 * @var string $type
 * @var array  $columns
 * @var array  $data
 * @var string $submit
 */

?>

<form class="wpgdprc-form wpgdprc-form--delete-request" data-wpgdprc=<?php echo $type; ?> method="POST" novalidate="novalidate">
	<div class="wpgdprc-message is-hidden"></div>
	<table class="wpgdprc-table">
		<thead class="wpgdprc-table__thead">
		<tr class="wpgdprc-table__tr wpgdprc-table__tr--thead">
            <?php foreach( $columns as $key => $column ) : ?>
                <?php $class = is_string($key) ? $key : sanitize_title($column); ?>
				<th class="wpgdprc-table__th wpgdprc-table__th--<?php echo $class; ?>" scope="col">
                    <?php echo $column; ?>
				</th>
            <?php endforeach; ?>
		</tr>
		</thead>
		<tbody class="wpgdprc-table__tbody">
        <?php foreach( $data as $id => $row ) : ?>
			<tr class="wpgdprc-table__tr wpgdprc-table__tr--tbody <?php if( $row[Data::COLUMN_ACTION] == Data::NO_ACTION ) echo 'wpgdprc-status--removed';?>" data-id="<?php echo $id; ?>">
                <?php foreach( $row as $index => $value ) : ?>
                    <?php $title = !empty($columns[ $index ]) ? $columns[ $index ] : ''; ?>
					<td class="wpgdprc-table__td" data-title="<?php echo esc_attr($title); ?>">
						<?php echo $value; ?>
					</td>
                <?php endforeach; ?>
			</tr>
        <?php endforeach; ?>
		</tbody>
	</table>
	<div class="wpgdprc-form__footer">
		<p class="wpgdprc-form__submit">
			<input type="submit" class="wpgdprc-form__input wpgdprc-form__input--submit wpgdprc-remove" value="<?php echo $submit; ?>"/>
		</p>
	</div>
</form>
