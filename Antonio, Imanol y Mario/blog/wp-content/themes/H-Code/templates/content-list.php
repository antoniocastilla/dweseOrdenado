      <tr>
            <td><?php echo get_the_date( get_option('date_format') ); ?></td>
            <td><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></td>
            <td><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></td>
            <?php $obj = get_post_type_object(get_post_type()); ?>
            <td><?php echo $obj->labels->singular_name; ?></td>
      </tr>